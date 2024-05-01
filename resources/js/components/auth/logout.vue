<template></template>
<script>
export default{
        created(){
            if(User.loggedIn()){
            User.logOut()
            Toast.fire({ icon: 'success', title: 'Logged Out Successfully' });
            }
            this.$router.push('/')
        }
    }


</script>