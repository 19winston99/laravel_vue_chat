<script>
export default {
  props: ["users", "loading"],
  emits: ["userSelected"],
  data() {
    return {
      usersContainer: [],
    };
  },
  methods: {
    selectUser(user) {
      this.$emit("userSelected", user);
    },
    searchUsers(text) {
      this.usersContainer = this.users.filter((user) =>
        user.name.toLowerCase().startsWith(text.toLowerCase())
      );
    },
  },
};
</script>

<template>
  <div class="main-list-container">
    <div
      class="title-container d-flex align-items-center justify-content-center"
    >
      <searchbar @search-users="searchUsers"></searchbar>
    </div>
    <div v-if="loading" class="d-flex justify-content-center">
      <div
        class="spinner-border text-primary spinner"
        role="status"
      >
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div class="users-lists-container" v-if="!loading">
      <div
        v-for="user in usersContainer.length ? usersContainer : users"
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
  border-radius: 10px;
  background: #252cc525;
  backdrop-filter: blur(5px);
  margin: 0 1em 0 1em;
}

.user-container:hover {
  cursor: pointer;
  background: #252dc59c;
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
  background: #252cc525;
  border-radius: 10px;
}

.title-container {
  background: #252cc525;
  padding: 0.5em;
  margin-bottom: 1em;
  border-radius: 10px;
  box-shadow: 1px 1px 3px black;
  height: 3em;
}

.spinner {
  width: 5em;
  height: 5em;
}
</style>
