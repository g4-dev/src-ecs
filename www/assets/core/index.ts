// expose core plugins
import { ApiPlugin } from './ts/plugins/api'

export const Api = (url: string) =>(new ApiPlugin(url));
