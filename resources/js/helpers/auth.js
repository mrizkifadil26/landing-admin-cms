import Axios from "axios";

export function registerUser(credentials) {
  return new Promise((resolve, reject) => {
    Axios.post('/api/auth/register', credentials)
      .then(response => {
        resolve(response.data);
      })
      .catch(err => {
        reject("An error occured... try again later.")
      })
  }) 
}

export function login(credentials) {
  return new Promise((resolve, reject) => {
    Axios.post('/api/auth/login', credentials)
      .then(response => {
        resolve(response.data);
      })
      .catch(err => {
        reject("Wrong username/password combination.")
      })
  })  
}

export function getLoggedinUser() {
  const userStr = localStorage.getItem('user');

  if (!userStr) {
    return null
  }

  return JSON.parse(userStr)
}