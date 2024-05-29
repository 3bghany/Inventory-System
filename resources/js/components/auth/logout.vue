<template></template>
<script>
export default{
        created(){
            if(User.loggedIn()){
            
            axios.post('/api/auth/logout')
            .then(() => {
                User.logOut();
                this.$router.push('/');
                Toast.fire({ icon: 'success', title: 'Logged Out Successfully' });
            })
            .catch();
            }

        }
    }


</script>