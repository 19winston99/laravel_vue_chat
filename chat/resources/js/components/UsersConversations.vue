<script>
export default {
  props: ["conversations", "currentAuthUser", "usersBlocked", "loading"],
  emits: ["userSelected"],
  methods: {
    selectUser(user) {
      this.$emit("userSelected", user);
    },
    unlockUser(userBlockedId) {
      axios.delete("/api/usersBlocked/" + userBlockedId).then((response) => {
        console.log(response.data.success);
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
      <div v-if="loading" class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <!-- Button trigger modal -->
      <button
        type="button"
        class="btn btn-sm btn-outline-danger rounded-circle text-white"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
      >
        <i class="bi bi-person-fill-lock"></i>
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
    <!-- <hr /> -->
    <div v-if="!loading" class="users-conversations-container">
      <div
        v-for="user in conversations"
        :key="user.id"
        @click="selectUser(user)"
      >
        <div class="d-flex ps-5 mb-1 align-items-center gap-1 user-container">
          <img
            :src="'images/users/' + user.image"
            class="img-fluid profile-image"
            alt="user_image"
          />
          <p class="m-0">{{ user.name }} {{ user.lastname }}</p>
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
  border: 1px solid #312e2e;
  border-radius: 50px;
}

.user-container:hover {
  cursor: pointer;
  background-color: #312e2e;
  border-radius: 50px;
}

.users-conversations-container {
  overflow-y: scroll;
  height: 22em;
}

.users-conversations-container::-webkit-scrollbar {
  width: 12px;
}

.users-conversations-container::-webkit-scrollbar-track {
  background: #252525;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.users-conversations-container::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 10px;
}

.title-container {
  background: rgb(59, 7, 59);
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
  background: rgba(139, 0, 0, 0.31);
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
  background: #252525;
  border-radius: 10px;
}
</style>
