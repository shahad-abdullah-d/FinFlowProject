import axios from "axios";

const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});
//  اي ريكويست بيطلع من رياكت  لازم يمر من هنا 
api.interceptors.request.use((config) => {
    // جيب التوكن اللي خزناه في اللوكل ستوريج 
  const token = localStorage.getItem("token");
//اذا فيه توكن ؟ ارسل التوكن مع الريكويست  
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
});

export default api;