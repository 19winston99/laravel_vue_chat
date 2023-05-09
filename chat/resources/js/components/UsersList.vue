<script>
export default {
  props: ["users"],
  emits: ["userSelected"],
  methods: {
    selectUser(user) {
      this.$emit("userSelected", user);
    },
  },
};
</script>

<template>
  <div class="main-list-container">
    <h5 class="text-center">Lista Utenti</h5>
    <hr />
    <div class="users-lists-container">
      <div v-for="user in users" :key="user.id" @click="selectUser(user)">
        <div
          class="d-flex justify-content-center align-items-center gap-1 user-container"
        >
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
.main-list-container {
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
}

.user-container:hover {
  cursor: pointer;
  background-color: #312e2e;
  border-radius: 50px;
}

.users-lists-container {
  overflow-y: scroll;
  height: 22em;
}

.users-lists-container::-webkit-scrollbar {
  width: 12px;
}

.users-lists-container::-webkit-scrollbar-track {
  background: #ccc;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.users-lists-container::-webkit-scrollbar-thumb {
  background: #252525;
  border-radius: 10px;
}
</style>
