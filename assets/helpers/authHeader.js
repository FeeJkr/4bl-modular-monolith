export function authHeader() {
    return { 'Authorization': 'Bearer ' + localStorage.getItem('token') };
}
