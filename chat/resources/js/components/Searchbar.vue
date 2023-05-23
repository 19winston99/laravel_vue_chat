<script>
export default {
  data() {
    return {
      text: "",
    };
  },
  methods: {
    searchUsers() {
      this.$emit("search-users", this.text);
    },
  },
  emits: ["search-users"],
};
</script>

<template>
  <input
    type="text"
    v-model="text"
    class="form-control searchbar"
    @input="searchUsers"
    placeholder="Search users..."
  />
</template>

<style>
.searchbar {
  width: 20em;
  height: 2em;
  border-radius: 64px;
}
</style>