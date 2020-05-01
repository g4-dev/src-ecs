# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

current_dir      = File.dirname(File.expand_path(__FILE__))

if(!File.exist?("#{current_dir}/vm_config.yaml"))
  puts "You need a file named vm_config.yaml, run cp vm_config.dist.yaml vm_config.yaml"
  exit
end

yml              = YAML.load_file("#{current_dir}/vm_config.yaml")
conf, vm, rsync_exclude         = yml['conf'], yml['vm'], yml['rsync_exclude']
os               = conf['box'] ? conf['box'] : "loic-roux-404/deb-g4"

# book repo
playbook_name    = "playbook-#{conf['projectname']}"
playbook         = "https://github.com/#{conf['org']}/#{playbook_name}.git"

### work path variable to change in debug mode
# Be aware of shared folders when deleting things
debug            = conf['debug_playbook']
folder           = debug ? '/data' : '/tmp'
web_dir          = "/data/#{conf['projectname']}/#{conf['web_path']}"

# provision status
IS_PROVISIONNING = ARGV[1] == '--provision' 
PROVISIONNED     = File.exist? File.dirname(__FILE__) + "/.vagrant/machines/default/virtualbox/action_provision"
# is os
IS_UNIX          = Vagrant::Util::Platform.darwin? || Vagrant::Util::Platform.linux?
# nfs config
conf['nfs'] = IS_UNIX
NFS_ENABLED = !conf['nfs_force_disable'] && conf['nfs'] && !IS_PROVISIONNING  && PROVISIONNED

if !Vagrant.has_plugin?('vagrant-hostmanager')
  system("vagrant plugin install vagrant-hostmanager")
end

hosts            = ""
hosts << conf['servername'] << " "

Vagrant.require_version ">= 2.2.2"

Vagrant.configure(2) do |config|
  config.vm.box = os

  id_rsa_path        = File.join(Dir.home, ".ssh", "id_rsa")
  id_rsa_ssh_key     = File.read(id_rsa_path)
  id_rsa_ssh_key_pub = File.read(File.join(Dir.home, ".ssh", "id_rsa.pub"))
  insecure_key_path  = File.join(Dir.home, ".vagrant.d", "insecure_private_key")

  config.ssh.insert_key = false
  config.ssh.forward_agent = true
  config.ssh.private_key_path = [id_rsa_path, insecure_key_path]

  config.vm.provider "virtualbox" do |vb|
      vm.each do |name, param|
        vb.customize ["modifyvm", :id, "--#{name}", param]
      end
  end

  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.network "forwarded_port", guest: 82, host: 8082, auto_correct: true
  config.vm.network "forwarded_port", guest: 3306, host: 3366, auto_correct: true

  config.vm.hostname = conf['servername']
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.ignore_private_ip = false
  config.hostmanager.include_offline = true
  config.hostmanager.aliases = hosts
  config.vm.network :private_network, ip: conf['private_ip']

  config.vm.synced_folder ".", "/vagrant", disabled: true

  if conf['smb'] && NFS_ENABLED
    puts 'Disable nfs or smb, two shared folder make an over use of CPU & RAM'
    exit
  end

  if conf['smb'] && !debug & !NFS_ENABLED
    config.vm.synced_folder ".", "/data/ecs", type: 'smb',
    mount_options: ["vers=2.0"]
  end

  if !debug
    $init = <<-SCRIPT
    rm -rf #{folder}/#{playbook_name} || true
    git clone #{playbook} /tmp/#{playbook_name} && cd /tmp/#{playbook_name} && git reset --hard origin/#{conf['playbook_version']}
    SCRIPT

    config.vm.provision "shell", inline: $init, privileged: false
  end

  if debug
    config.vm.synced_folder "./#{playbook_name}/", "/data/#{playbook_name}/", type: "rsync"
  end

  # add your ssh keys to clone private repos
  ssh_path = "/home/vagrant/.ssh"
  config.vm.provision :shell,
    privileged: false,
    inline: "echo '#{id_rsa_ssh_key}' > #{ssh_path}/id_rsa && chmod 600 #{ssh_path}/id_rsa"
  config.vm.provision :shell,
    privileged: false,
    inline: "echo '#{id_rsa_ssh_key_pub}' > #{ssh_path}/authorized_keys && chmod 600 #{ssh_path}/authorized_keys"

  ## Install and configure software
  config.vm.provision "ansible_local" do |ansible|
      ansible.provisioning_path = "#{folder}/#{playbook_name}/"
      ansible.playbook = "playbook.yml"
      ansible.become = true
      ansible.verbose = ""
      ansible.extra_vars = conf
  end

  if !NFS_ENABLED && !conf['smb']
    config.vm.synced_folder "./", "/data/ecs", type: "rsync",
        rsync__auto: true,
        rsync__args: ["--archive", "--delete", "--no-owner", "--no-group","-q", "-W"],
        rsync__exclude: rsync_exclude
  end

  if NFS_ENABLED && Vagrant::Util::Platform.darwin? && !Vagrant.has_plugin?('vagrant-bindfs')
     system('vagrant plugin install vagrant-bindfs')
  end

  if NFS_ENABLED
    # NFS config / bind vagrant user to nfs mount
    if Vagrant::Util::Platform.darwin?
        config.vm.synced_folder "./", "/data/ecs", nfs: true, mount_options: ['rw','tcp','fsc','noatime','rsize=8192','wsize=8192','noacl','actimeo=2'],
        linux__nfs_options: ['rw','no_subtree_check','all_squash','async']
        config.bindfs.bind_folder web_dir, web_dir
    else
      # linux nfs 4 server
      config.vm.synced_folder "./www", web_dir, nfs: true, nfs_version: 4, nfs_udp: false, mount_options: ['rw','noac','actimeo=2','nolock']
    end
  else
    # reload nfs / shared folder after provision
    config.trigger.after :provision do |t|
      t.info = "Reboot after provisioning"
      t.run = { :inline => "vagrant reload" }
    end
  end

  #if conf['ssl']
    #config.trigger.after :up do |t|
      #cert = "#{conf['servername']}.combined.pem"
      #cert_path = "/etc/ssl/#{conf['servername']}/#{cert}"
      #t.run = { "scp -P 22 vagrant@#{conf['servername']}:#{cert_file} docs/" }

      #if IS_UNIX
          #t.run = { inline: => "sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain docs/#{cert}" }
      #else
        #t.run = { inline: => "certutil -enterprise -f -v -AddStore 'Root' 'certificates/ca/ca.crt'" }
      #end
    #end
  #end
end
