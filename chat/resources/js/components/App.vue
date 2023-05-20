<script>
export default {
  props: ["auth"],
  data() {
    return {
      users: [],
      conversations: [],
      currentUserSelected: null,
      userObject: JSON.parse(this.auth),
      usersBlocked: [],
      loading: true,
    };
  },
  methods: {
    getUsers() {
      axios.get("api/users").then((response) => {
        this.users = response.data;
      });
    },
    getConversations() {
      this.loading = true;
      axios
        .get("api/conversations?currentUser=" + this.userObject.id)
        .then((response) => {
          this.conversations = response.data;
          this.loading = false;
        });
    },
    setUserChat(user) {
      this.currentUserSelected = user;
    },
    getUsersBlocked() {
      axios
        .get("api/usersLocked?currentUser=" + this.userObject.id)
        .then((response) => {
          this.usersBlocked = response.data;
        });
    },
  },
  mounted() {
    this.getUsers();
    this.getConversations();
    this.getUsersBlocked();
  },
};
</script>

<template>
  <div class="d-flex justify-content-between">
    <users-conversations
      :currentAuthUser="userObject"
      :conversations="conversations"
      @userSelected="setUserChat"
      :usersBlocked="usersBlocked"
      :loading="loading"
      @userBlocked="getUsersBlocked"
    ></users-conversations>
    <div
      v-if="!currentUserSelected"
      class="warning-container d-flex justify-content-center align-items-start"
    >
      <div class="not-user-selected">
        <lottie-player
          src="https://assets4.lottiefiles.com/packages/lf20_9a9edhvx.json"
          background="transparent"
          speed="1"
          style="width: 300px; height: 300px"
          loop
          autoplay
        ></lottie-player>
        <p>Seleziona un utente...</p>
      </div>
    </div>
    <chat
      v-if="currentUserSelected"
      :currentAuthUser="userObject"
      :userSelected="currentUserSelected"
      :usersBlocked="usersBlocked"
    ></chat>
    <users-list
      :users="users"
      @userSelected="setUserChat"
      :loading="loading"
    ></users-list>
  </div>
</template>

<style>
.warning-container {
  width: 50vw;
  height: 75vh;
}

.not-user-selected {
  text-align: center;
}

.i-size {
  font-size: 3em;
}
</style>