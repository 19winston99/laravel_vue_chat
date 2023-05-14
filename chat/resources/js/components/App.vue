<script>
export default {
  props: ["auth"],
  data() {
    return {
      users: [],
      conversations: [],
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
    getConversations() {
      axios
        .get("api/conversations?currentUser=" + this.userObject.id)
        .then((response) => {
          this.conversations = response.data;
        });
    },
    setUserChat(user) {
      this.currentUserSelected = user;
    },
  },
  mounted() {
    this.getUsers();
    this.getConversations();
  },
};
</script>

<template>
  <div class="d-flex">
    <users-conversations :currentAuthUser="userObject" :conversations="conversations" @userSelected="setUserChat"></users-conversations>
    <chat
      v-if="currentUserSelected"
      :currentAuthUser="userObject"
      :userSelected="currentUserSelected"
    ></chat>
    <users-list :users="users" @userSelected="setUserChat"></users-list>
  </div>
</template>