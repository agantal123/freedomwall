<template>
<div class="w-full overflow-x-hidden flex flex-col">
  <main class="w-full flex-grow p-6">
    <h1 class="text-3xl text-black pb-2"><b>Manage Users</b></h1>
    <router-view> </router-view>
  </main>
</div>
</template>
<script>
export default {
   name: 'manageUser',
}
</script>