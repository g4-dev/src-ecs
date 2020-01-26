import 'axios'

export class ApiPlugin implements Api{
	constructor(public url: string){

	}

	public post(params: Object): Object
	{
		return {}
	}

	public get<Array>(params: Array): any[]
	{
		return Array()
	}
}

export interface Api {
	post(params: Object): Object

	get<Array>(params: Array): any[]
}