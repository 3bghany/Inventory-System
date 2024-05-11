import AppStorage from "./AppStorage.js";

class User{
    responseAfterLogin(res){
        const access_token=res.data.access_token
        const username=res.data.data.name
            AppStorage.store(access_token,username)
    }

    hasToken(){
        const storeToken = localStorage.getItem('token');
        if(storeToken){
            return  true
        }
        false
    }
    loggedIn(){
        return this.hasToken()
    }
    name(){
        if(this.loggedIn()){
            return localStorage.getItem('user')
        }
    }
    logOut() {
        AppStorage.clear();
    }
    updateUserName(username){
        AppStorage.storeUser(username);
    }
    

    
}
export default User =new User();