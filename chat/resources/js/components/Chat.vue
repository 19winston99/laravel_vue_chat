<script>
export default {
  props: ["currentAuthUser", "userSelected"],
  data() {
    return {
      messages: [],
    };
  },
  methods: {
    getMessages() {
      axios
        .get(
          "api/messages?currentUser=" +
            this.currentAuthUser.id +
            "&selectedUser=" +
            this.userSelected.id
        )
        .then((response) => {
          this.messages = response.data;
        });
    },
  },
  watch: {
    userSelected: {
      handler(newUser, oldUser) {
        if (newUser != oldUser) {
          this.getMessages();
        }
      },
    },
  },
  mounted() {
    this.getMessages();
  },
};
</script>

<template>
  <div class="main-chat-container">
    <div
      class="d-flex justify-content-center align-items-center gap-2 current-chat-user-info"
    >
      <img
        :src="'images/users/' + userSelected.image"
        class="img-fluid profile-image"
        alt="user_image"
      />
      <p class="m-0">{{ userSelected.name }} {{ userSelected.lastname }}</p>
    </div>
    <div class="messages-container">
      <div v-for="message in messages" :key="message.id">
        <img
          v-if="message.image != null"
          :src="'images/messages/' + message.image"
        />
        <p v-if="message.message != null">
          {{ message.message }}
        </p>
      </div>
    </div>
    <send-message
      :currentAuthUser="currentAuthUser"
      :userSelected="userSelected"
    ></send-message>
  </div>
</template>

<style>
.main-chat-container {
  width: 50vw;
  height: 75vh;
}

.profile-image {
  border-radius: 50%;
  width: 3em;
  height: 3em;
  object-fit: cover;
}

.current-chat-user-info {
  padding: 0.3em;
  box-shadow: 2px 2px 11px black;
  border-radius: 10px;
  width: 20em;
  margin: 0 auto;
  border: 2px solid;
  animation: changeBorder 5s infinite alternate linear;
}

@keyframes changeBorder {
  0% {
    border-color: #00ff00;
  }

  25% {
    border-color: #228b22;
  }

  50% {
    border-color: #66ff00;
  }

  75% {
    border-color: #adff2f;
  }

  100% {
    border-color: #00cc99;
  }
}

img {
  width: 1em;
}

.messages-container {
  padding: 1em;
  overflow-y: scroll;
  height: 22em;
}

.messages-container::-webkit-scrollbar {
  width: 12px;
}

.messages-container::-webkit-scrollbar-track {
  background: #ccc;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.messages-container::-webkit-scrollbar-thumb {
  background: #252525;
  border-radius: 10px;
}
</style>
