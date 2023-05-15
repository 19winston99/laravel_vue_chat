<script>
export default {
  props: ["currentAuthUser", "userSelected", "usersBlocked"],
  data() {
    return {
      messages: [],
      loadingChat: true,
    };
  },
  methods: {
    getMessages() {
      this.loadingChat = true;
      axios
        .get(
          "api/messages?currentUser=" +
            this.currentAuthUser.id +
            "&selectedUser=" +
            this.userSelected.id
        )
        .then((response) => {
          this.messages = response.data;
          this.loadingChat = false;
        });
    },
    shouldDisplayMessage(message) {
      const userId = message.sender_id;
      const isBlocked = this.usersBlocked.some(
        (blockedUser) => blockedUser.user_blocked.id === userId
      );
      return !isBlocked && (message.message != null || message.image != null);
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
  <div
    v-if="loadingChat"
    class="spinner-border text-success ms-3 chat-spinner"
    role="status"
  >
    <span class="visually-hidden">Loading...</span>
  </div>
  <div v-if="!loadingChat" class="main-chat-container">
    <div
      class="d-flex justify-content-center align-items-center gap-2 current-chat-user-info"
    >
      <img
        :src="'images/users/' + userSelected.image"
        class="img-fluid profile-image"
        alt="user_image"
      />
      <p
        v-if="
          usersBlocked.some((user) => user.user_blocked.id === userSelected.id)
        "
        class="m-0"
      >
        {{ userSelected.name }}
        {{ userSelected.lastname }} <i class="bi bi-lock-fill"></i>
      </p>
      <p v-else class="m-0">
        {{ userSelected.name }} {{ userSelected.lastname }}
      </p>
    </div>
    <div class="messages-container">
      <div
        v-for="message in messages"
        :key="message.id"
        :class="{
          message_sent: message.sender_id == currentAuthUser.id,
          complex_message:
            message.sender_id == currentAuthUser.id &&
            message.message != null &&
            message.image != null,
          message_receive: message.sender_id != currentAuthUser.id,
        }"
      >
        <img
          v-if="message.image != null && shouldDisplayMessage(message)"
          :src="'images/messages/' + message.image"
          class="chat-image"
        />
        <p
          class="mt-2 mb-2 ms-0 me-0 chat-message"
          v-if="message.message != null && shouldDisplayMessage(message)"
        >
          {{ message.message }}
        </p>
      </div>
    </div>
    <send-message
      v-if="
        !usersBlocked.some((user) => user.user_blocked.id === userSelected.id)
      "
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
    border-color: purple;
  }

  25% {
    border-color: rgb(75, 6, 75);
  }

  50% {
    border-color: rgb(37, 4, 37);
  }

  75% {
    border-color: rgb(190, 0, 190);
  }

  100% {
    border-color: rgb(229, 16, 229);
  }
}

.chat-image {
  width: 10em;
  margin-bottom: 0.5em;
  border-radius: 10px;
  box-shadow: 1px 1px 3px black;
}

.messages-container {
  padding: 3em;
  overflow-y: scroll;
  height: 22em;
}

.messages-container::-webkit-scrollbar {
  width: 12px;
}

.messages-container::-webkit-scrollbar-track {
  background: #252525;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.messages-container::-webkit-scrollbar-thumb {
  background: rgb(37, 4, 37);
  border-radius: 10px;
}

.message_sent {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.chat-message {
  text-align: start;
}

.complex_message {
  display: flex;
  justify-content: end;
  align-items: end;
  flex-direction: column;
}

.message_sent :not(.chat-image) {
  /* display: inline-block; */
  background-color: rgb(59, 7, 59);
  box-shadow: 1px 1px 3px black;
  min-width: 6em;
  word-wrap: break-word;
  max-width: 20em;
  overflow-y: hidden;
  height: auto;
  border-radius: 10px;
  padding: 0.5em;
}

.message_receive :not(.chat-image) {
  display: inline-block;
  background-color: purple;
  box-shadow: 1px 1px 3px black;
  min-width: 6em;
  word-wrap: break-word;
  max-width: 20em;
  overflow-y: hidden;
  height: auto;
  border-radius: 10px;
  padding: 0.5em;
}

.chat-spinner {
  margin-top: 12em;
}
</style>
