<script>
export default {
  props: ["currentAuthUser", "userSelected"],
  emits: ["send-message"],
  data() {
    return {
      messageContent: "",
      conversation_id: 1,
      currentConversation: [],
    };
  },
  methods: {
    getCurrentConversation() {
      axios
        .get(
          "api/conversation?current_id=" +
            this.currentAuthUser.id +
            "&user_id=" +
            this.userSelected.id
        )
        .then((response) => {
          this.currentConversation = response.data;
        });
    },
    addConversation() {
      axios.post("api/conversations", {
        first_user_id: this.currentAuthUser.id,
        second_user_id: this.userSelected.id,
      });
    },
    sendMessage() {
      const formData = new FormData();
      formData.append("conversation_id", this.conversation_id);
      formData.append("sender_id", this.currentAuthUser.id);
      formData.append("recipient_id", this.userSelected.id);
      formData.append("message", this.messageContent);
      formData.append("image", null);
      axios.post("api/messages", formData).then((response) => {
        if (response.data.success) {
          this.$emit("send-message", {
            id: response.data.id,
            conversation_id: 1,
            sender_id: this.currentAuthUser.id,
            recipient_id: this.userSelected.id,
            message: this.messageContent,
            image: null,
          });
        }
      });
    },
  },
};
</script>

<template>
  <input type="text" v-model="messageContent" placeholder="inserisci testo" />
  <button @click="sendMessage">invia</button>
</template>