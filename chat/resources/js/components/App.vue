<script>
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
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
        .get("api/blockedUsers?currentUser=" + this.userObject.id)
        .then((response) => {
          this.usersBlocked = response.data;
        });
    },
  },
  mounted() {
    this.getUsers();
    this.getConversations();
    this.getUsersBlocked();

    Echo.join("chat")
      .here((users) => {
        //
      })
      .joining((user) => {
        toast.success(user.name + " è online");
      })
      .leaving((user) => {
        toast.dark(user.name + " è offline");
      });
  },
};
</script>

<template>
  <div class="d-flex justify-content-between main">
    <users-conversations
      :currentAuthUser="userObject"
      :conversations="conversations"
      @userSelected="setUserChat"
      :usersBlocked="usersBlocked"
      :loading="loading"
      @userBlocked="getUsersBlocked"
      @unlockUser="getUsersBlocked"
    ></users-conversations>
    <div
      v-if="!currentUserSelected"
      class="warning-container d-flex justify-content-center align-items-start"
    >
      <div class="not-user-selected">
        <i class="bi bi-info-circle-fill i-size"></i>
        <p>Seleziona un utente...</p>
      </div>
    </div>
    <chat
      v-if="currentUserSelected"
      :currentAuthUser="userObject"
      :userSelected="currentUserSelected"
      :usersBlocked="usersBlocked"
    ></chat>
    <div>
      <users-list
        :users="users"
        @userSelected="setUserChat"
        :loading="loading"
      ></users-list>
    </div>
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
  color: darkblue;
}

@media screen and (max-width: 1000px) {
  .main {
    flex-direction: column;
  }

  .warning-container {
    width: auto;
    height: auto;
  }
}
</style>