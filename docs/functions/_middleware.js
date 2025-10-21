export async function onRequest(context) {
    // Get the authorization header from the request
    const auth = context.request.headers.get('Authorization');

    // If no authorization header is present, prompt for credentials
    if (!auth) {
        return new Response('Authentication required', {
            status: 401,
            headers: {
                'WWW-Authenticate': 'Basic realm="Secure Area"'
            }
        });
    }

    // Split the auth header to get the encoded credentials
    const [scheme, encoded] = auth.split(' ');

    // Validate it's using Basic auth
    if (!encoded || scheme !== 'Basic') {
        return new Response('Invalid authentication', {
            status: 401,
            headers: {
                'WWW-Authenticate': 'Basic realm="Secure Area"'
            }
        });
    }

    // Decode the Base64 credentials
    const decoded = atob(encoded);
    const [username, password] = decoded.split(':');

    // Your credentials here
    const VALID_USERNAME = 'traccar';
    const VALID_PASSWORD = 'docs';

    // Check if the credentials match
    if (username !== VALID_USERNAME || password !== VALID_PASSWORD) {
        return new Response('Invalid credentials', {
            status: 401,
            headers: {
                'WWW-Authenticate': 'Basic realm="Secure Area"'
            }
        });
    }

    // If authentication passes, continue to the requested page
    return context.next();
}