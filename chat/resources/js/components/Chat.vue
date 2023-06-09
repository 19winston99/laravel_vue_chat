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
    deleteMessage(messageId) {
      axios.delete("api/messages/" + messageId).then((response) => {
        this.filterArray(messageId);
      });
    },
    filterArray(id) {
      this.messages = this.messages.filter((el) => el.id !== id);
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
    window.Echo.private("chat").listen("NewMessage", (data) => {
      this.messages.push(data.message);
    });
  },
};
</script>

<template>
  <div
    v-if="loadingChat"
    class="spinner-grow text-primary spinner"
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
        <div
          v-if="message.image != null && shouldDisplayMessage(message)"
          class="d-flex align-items-center message-button-container"
        >
          <img
            v-if="message.image != null"
            :src="'images/messages/' + message.image"
            class="chat-image"
          />
          <button
            v-if="
              message.image != null && message.sender_id == currentAuthUser.id
            "
            class="btn btn-sm button"
            @click="deleteMessage(message.id)"
          >
            <i class="bi bi-trash trash"></i>
          </button>
        </div>
        <div
          v-if="message.message != null && shouldDisplayMessage(message)"
          class="d-flex align-items-center"
        >
          <p
            class="mt-1 mb-1 ms-0 me-0 chat-message"
            v-if="message.message != null"
          >
            {{ message.message }}
          </p>
          <button
            v-if="message.sender_id == currentAuthUser.id"
            class="btn btn-sm button"
            @click="deleteMessage(message.id)"
          >
            <i class="bi bi-trash trash"></i>
          </button>
        </div>
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
  border-radius: 10px;
  width: 20em;
  margin: 0 auto 1em;
  box-shadow: inset 1px 1px 5px #252525;
}

.chat-image {
  width: 10em;
  margin-bottom: 0.5em;
  border-radius: 10px;
  box-shadow: 1px 1px 3px black;
}

.messages-container {
  padding: 2em;
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
  background: #252cc525;
  border-radius: 10px;
}

.message_sent {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.chat-message {
  text-align: start;
  background: #252cc525;
}

.complex_message {
  display: flex;
  justify-content: end;
  align-items: end;
  flex-direction: column;
}

.message_sent :not(.chat-image) {
  min-width: 6em;
  word-wrap: break-word;
  max-width: 20em;
  height: auto;
  border-radius: 10px;
  padding: 0.5em;
}

.message_receive :not(.chat-image) {
  display: inline-block;
  min-width: 6em;
  word-wrap: break-word;
  max-width: 20em;
  height: auto;
  border-radius: 10px;
  padding: 0.5em;
}

.button {
  border: none !important;
  min-width: 0.5em !important;
  background: transparent !important;
  box-shadow: none !important;
}

.trash:hover {
  border: 1px solid #252525;
}

.spinner {
  width: 5em;
  height: 5em;
}

@media screen and (max-width: 1000px) {
  .main-chat-container {
    width: auto;
    height: auto;
  }
}
</style>
