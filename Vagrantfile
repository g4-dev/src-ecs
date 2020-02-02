# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

current_dir      = File.dirname(File.expand_path(__FILE__))

if(!File.exist?("#{current_dir}/vm_config.yaml"))
  puts "You need a file named vm_config.yaml, don't delete vm_config.dist.yaml"
  exit
end

yml              = YAML.load_file("#{current_dir}/vm_config.yaml")
conf, vm         =  yml['conf'], yml['vm']
# If you're on a new build of Windows 10 you can try to use NFS
# os, box_version  = conf['os'], conf['box_version']
os               = "bento/debian-" + conf['os']
# book repo
playbook_name    = "playbook-#{conf['projectname']}"
playbook         = "https://github.com/#{conf['org']}/#{playbook_name}.git" 

### work path variable to change in debug mode
# Be aware of shared folders when deleting things
debug            = conf['debug_playbook']
folder           = debug ? '/vagrant' : '/tmp'
web_dir          = "/data/#{conf['projectname']}/#{conf['web_path']}"
# nfs config
conf['nfs'] = Vagrant::Util::Platform.darwin? || Vagrant::Util::Platform.linux?
NFS_ENABLED = !conf['nfs_force_disable'] && conf['nfs'] && ARGV[1] != '--provision' && (File.exist? File.dirname(__FILE__) + "/.vagrant/machines/default/virtualbox/action_provision")
# ssl config
hosts            = ""

if !Vagrant.has_plugin?('vagrant-hostmanager')
  puts "The vagrant-hostmanager plugin is required. Please install it with \"vagrant plugin install vagrant-hostmanager\""
  exit
end
hosts << conf['servername'] << " "

Vagrant.require_version ">= 2.2.2"

Vagrant.configure(2) do |config|
  config.vm.box = os
  #config.vm.box_version = "10.0.0"

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
  config.vm.network "forwarded_port", guest: 3306, host: 3366, auto_correct: true

  config.vm.hostname = conf['servername']
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.ignore_private_ip = false
  config.hostmanager.include_offline = true
  config.hostmanager.aliases = hosts
  config.vm.network :private_network, ip: conf['private_ip']

  if !debug
    config.vm.synced_folder ".", "/vagrant", disabled: true

    $init = <<-SCRIPT
    sudo apt -y install git
    rm -rf /tmp/#{playbook_name} || true
    git clone #{playbook} /tmp/#{playbook_name} && cd /tmp/#{playbook_name} && git reset --hard origin/#{conf['playbook_version']}
    SCRIPT

    config.vm.provision "shell", inline: $init, privileged: false
  end

  ## Install and configure software
  config.vm.provision "ansible_local" do |ansible|
      ansible.provisioning_path = "#{folder}/#{playbook_name}/"
      ansible.playbook = "playbook.yml"
      ansible.become = true
      ansible.verbose = ""
      ansible.extra_vars = conf
  end

    if Vagrant::Util::Platform.darwin? && !Vagrant.has_plugin?('vagrant-bindfs')
        exit "please run : vagrant plugin install vagrant-bindfs"
    end

  if NFS_ENABLED
    # NFS config / bind vagrant user to nfs mount
    if Vagrant::Util::Platform.darwin?
        config.vm.synced_folder "./www", web_dir, nfs: true, mount_options: ['rw','tcp','fsc','async','noatime','rsize=8192','wsize=8192','noacl','actimeo=2'],
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

  # fix ssh common issues
  ssh_path = "/home/vagrant/.ssh"
  config.vm.provision :shell, :inline => "echo '#{id_rsa_ssh_key }' > #{ssh_path}/id_rsa && chmod 600 #{ssh_path}/id_rsa"
  config.vm.provision :shell, :inline => "echo '#{id_rsa_ssh_key_pub }' > #{ssh_path}/authorized_keys && chmod 600 #{ssh_path}/authorized_keys"
end