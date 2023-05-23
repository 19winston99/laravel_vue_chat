<script>
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  props: ["conversations", "currentAuthUser", "usersBlocked", "loading"],
  emits: ["userSelected", "userBlocked"],
  methods: {
    selectUser(user) {
      this.$emit("userSelected", user);
    },
    isUserBlocked(userId) {
      return this.usersBlocked.some((user) => user.user_blocked.id === userId);
    },
    unlockUser(userBlockedId) {
      axios
        .head("/api/usersLocked/del/?id=" + userBlockedId)
        .then((response) => {
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error.response);
        });
    },
    blockUser(userId) {
      axios
        .post("api/usersLocked", {
          blocking_user_id: this.currentAuthUser.id,
          blocked_user_id: userId,
        })
        .then((response) => {
          toast.error('Utente bloccato.');
          this.$emit("userBlocked");
        });
    },
  },
};
</script>

<template>
  <div class="main-conversation-container">
    <div
      class="title-container d-flex align-items-center justify-content-between pe-5 ps-5"
    >
      <h5 class="text-center mb-0">Chat</h5>
      <!-- Button trigger modal -->
      <button
        type="button"
        class="btn btn-sm btn-dark rounded-circle"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
      >
        <i class="bi bi-person-fill-lock icon-block-list"></i>
      </button>

      <!-- Modal -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 text-black" id="exampleModalLabel">
                Utenti Bloccati <i class="bi bi-lock-fill"></i>
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body user-blocked-body">
              <div
                class="d-flex align-items-center justify-content-between pe-3 ps-3 user-blocked"
                v-for="userBlocked in usersBlocked"
                :key="userBlocked.id"
              >
                <div class="d-flex align-items-center gap-2">
                  <img
                    :src="'images/users/' + userBlocked.user_blocked.image"
                    class="img-fluid profile-image"
                    alt="user_image"
                  />
                  <p class="text-black m-0">
                    {{ userBlocked.user_blocked.name }}
                    {{ userBlocked.user_blocked.lastname }}
                  </p>
                </div>
                <button
                  class="btn btn-sm btn-outline-dark rounded-circle"
                  @click="unlockUser(userBlocked.id)"
                >
                  <i class="bi bi-unlock-fill"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="loading" class="d-flex justify-content-center">
      <div
        class="spinner-border text-primary spinner"
        role="status"
      >
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div v-if="!loading" class="users-conversations-container">
      <div
        v-for="user in conversations"
        :key="user.id"
        @click="selectUser(user)"
      >
        <div
          class="d-flex mb-1 align-items-center justify-content-between user-container"
        >
          <div class="d-flex ps-5 mb-1 align-items-center gap-1">
            <img
              :src="'images/users/' + user.image"
              class="img-fluid profile-image"
              alt="user_image"
            />
            <p class="m-0">{{ user.name }} {{ user.lastname }}</p>
          </div>
          <button
            v-if="!isUserBlocked(user.id) && user.id != currentAuthUser.id"
            class="btn btn-sm btn-light rounded-circle me-3"
            @click="blockUser(user.id)"
          >
            <i class="bi bi-person-fill-lock"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.main-conversation-container {
  width: 25vw;
  height: 75vh;
}

.profile-image {
  border-radius: 50%;
  width: 3em;
  height: 3em;
  object-fit: cover;
}

.user-container {
  padding: 0.5em;
  border-radius: 10px;
  background: #252cc525;
  backdrop-filter: blur(5px);
  margin: 0 1em 0 1em;
}

.user-container:hover {
  cursor: pointer;
  background: #252dc59c;
}

.users-conversations-container {
  overflow-y: scroll;
  height: 22em;
}

.users-conversations-container::-webkit-scrollbar {
  width: 12px;
}

.users-conversations-container::-webkit-scrollbar-track {
  background: #ccc;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.users-conversations-container::-webkit-scrollbar-thumb {
  background: #252cc525;
  border-radius: 10px;
}

.title-container {
  background: #252cc525;
  padding: 0.5em;
  margin-bottom: 1em;
  border-radius: 10px;
  box-shadow: 1px 1px 3px black;
}

.user-blocked {
  border-radius: 10px;
  padding: 0.3em;
}

.user-blocked:hover {
  cursor: pointer;
  background: #252cc525;
}

.user-blocked-body {
  height: 20em;
  overflow-y: scroll;
}

.user-blocked-body::-webkit-scrollbar {
  width: 12px;
}

.user-blocked-body::-webkit-scrollbar-track {
  background: #ccc;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.user-blocked-body::-webkit-scrollbar-thumb {
  background: #252cc525;
  border-radius: 10px;
}

.spinner {
  width: 5em;
  height: 5em;
}
</style>
