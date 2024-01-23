import {ofetch} from 'ofetch';

export default function useApi() {

    return ofetch.create({
        baseURL: 'http://127.0.0.1:8000',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        async onResponseError({request, response, options}) {
            // Log error
            console.log(
                "[fetch response error]",
                request,
                response.status,
                response.body
            );
            if (response.status === 401) {
                navigateTo('/login')
            }
        },
    });
}