<script>
import UsersConversations from './UsersConversations.vue';
export default {
  components: { UsersConversations },
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
      axios.get("api/conversations?currentUser=" + this.userObject.id).then((response) => {
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
  <users-list :users="users" @userSelected="setUserChat"></users-list>
  <chat
    v-if="currentUserSelected"
    :currentAuthUser="userObject"
    :userSelected="currentUserSelected"
  ></chat>
  <users-conversations :conversations="conversations"></users-conversations>
</template>