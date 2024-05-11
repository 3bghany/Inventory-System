<template>
              <div class="container-fluid" id="container-wrapper">
          <div class="text-center" style="margin: 150px;">
            <img src="../../../public/backend/img/error.svg" style="max-height: 100px;" class="mb-3">
            <h3 class="text-gray-800 font-weight-bold">{{ $t("main.Oopss!") }}</h3>
            <p class="lead text-gray-800 mx-auto">404 {{ $t("main.Page Not Found") }}</p>
            <router-link to="/home">← {{ $t("main.Back to Dashboard") }}</router-link>
          </div>

        </div>
    </template>
<script>

</script>
<style>

</style>