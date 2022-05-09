<template>
  <div id="login">
    <slot />
  </div>
</template>

<script>
export default {
  name: "AuthComponent",
};
</script>

<style>
#login {
  background: #262626;
  position: relative;
  min-height: 100vh;
}
</style>