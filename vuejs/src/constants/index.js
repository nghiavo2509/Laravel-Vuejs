import axios from "axios";

export const PUBLIC_LAYOUT = 'default';
export const getHeader = function() {
    const tokenData = window.localStorage.getItem('auth_token');
    const headers = {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + tokenData
    }
    return headers;
}

export const getUser = async function() {
    const res = await axios.get(`http://127.0.0.1:8000/api/user`, {
        headers: getHeader(),
    });
    return res.data;
}