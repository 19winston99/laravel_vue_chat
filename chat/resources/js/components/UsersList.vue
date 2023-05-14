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
    <div class="title-container d-flex align-items-center justify-content-center">
      <h5 class="mb-0">Contatti</h5>
    </div>
    <!-- <hr /> -->
    <div class="users-lists-container">
      <div v-for="user in users" :key="user.id" @click="selectUser(user)">
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
  border: 1px solid #312e2e;
  border-radius: 50px;
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
  background: #252525;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.users-lists-container::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 10px;
}

.title-container {
  background: rgb(59, 7, 59);
  padding: 0.5em;
  margin-bottom: 1em;
  border-radius: 10px;
  box-shadow: 1px 1px 3px black;
  height: 3em;
}
</style>
