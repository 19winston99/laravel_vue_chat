<script>
export default {
  props: ["auth"],
  data() {
    return {
      users: [],
      currentUserSelected: null,
      userObject: JSON.parse(this.auth),
    };
  },
  methods: {
    getUsers() {
      axios.get("api/users").then((response) => {
        this.users = response.data;
      });
    },
    setUserChat(user) {
        this.currentUserSelected = user;
    },
  },
  mounted() {
    this.getUsers();
  }
};
</script>

<template>
  <users-list :users="users" @userSelected="setUserChat"></users-list>
  <chat v-if="currentUserSelected" :currentAuthUser="userObject" :userSelected="currentUserSelected"></chat>
</template>