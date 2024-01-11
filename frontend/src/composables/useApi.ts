import { ofetch } from 'ofetch';

export default function useApi() {

    return ofetch.create({
        baseURL: 'http://127.0.0.1:8000',
        credentials: 'include',
    });
}
