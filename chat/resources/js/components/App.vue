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
        <i class="bi bi-cone-striped i-size"></i>
        <p>Seleziona un utente</p>
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
  box-shadow: 1px 1px 5px black;
  padding: 1em;
  border-radius: 10px;
  text-align: center;
}

.i-size {
  font-size: 3em;
}
</style>