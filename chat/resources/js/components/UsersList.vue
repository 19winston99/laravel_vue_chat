<script>
export default {
  props: ["users"],
  emits: ['userSelected'],
  methods: {
    selectUser(user) {
        this.$emit('userSelected', user)
    }
  }
};
</script>

<template>
  <div>
    <p v-for="user in users" :key="user.id" @click="selectUser(user)">
      {{ user.name }}
    </p>
  </div>
</template>