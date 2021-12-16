import axios from "axios"

const token = localStorage.getItem('token');
const Authorization = `Bearer ${token}`;

const api = axios.create({
    baseURL: process.env.MIX_API_URL,
    withCredentials: true,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Access-Control-Allow-Origin': `${process.env.MIX_APP_URL}`,
        'Content-Type': 'multipart/form-data; charset=UTF-8',
        'Accept': 'application/json',
        Authorization
    }
})


export default async function apiRequest(url, requestOptions) {
    try {
        const response = await api(url, requestOptions);
        return response
    } catch (e) {
        console.log("try/catch error in API request");
        return e
    }
}
