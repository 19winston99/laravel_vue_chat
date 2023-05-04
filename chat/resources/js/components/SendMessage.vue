<script>
export default {
  props: ["currentAuthUser", "userSelected"],
  emits: ["send-message"],
  data() {
    return {
      messageContent: "",
      image: null,
    };
  },
  methods: {
    sendMessage() {
      if (this.messageContent || this.image) {
        const formData = new FormData();
        formData.append("sender_id", this.currentAuthUser.id);
        formData.append("recipient_id", this.userSelected.id);
        if (this.messageContent) {
          formData.append("message", this.messageContent);
        }
        if (this.image) {
          formData.append("image", this.image);
        }
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
      }
    },
  },
  watch: {
    userSelected: {
      handler(newUser, oldUser) {
        if (newUser != oldUser) {
          this.messageContent = "";
          this.image = null;
          // this.$refs.inputFile.value = null;
        }
      },
    },
  },
};
</script>

<template>
  <input type="text" v-model="messageContent" placeholder="inserisci testo" />
  <button @click="sendMessage">invia</button>
</template>