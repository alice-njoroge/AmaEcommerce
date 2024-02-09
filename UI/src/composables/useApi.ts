import {ofetch} from 'ofetch';

export default function useApi() {

    return ofetch.create({
        baseURL: 'http://api.amazon.localhost',
        credentials: 'include',

        async onResponseError({request, response, options}) {
            // Log error
            console.log(
                "[fetch response error]",
                request,
                response.status,
                response.body
            );
            if (response.status === 401) {
                // navigateTo('/login')
            }
        },
    });
}
