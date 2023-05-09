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
              sender_id: this.currentAuthUser.id,
              recipient_id: this.userSelected.id,
              message: this.messageContent,
              image: response.data.image,
            });
            this.messageContent = "";
            this.image = null;
            this.$refs.inputFile.value = null;
          }
        });
      }
    },
    onFileSelected(event) {
      this.image = event.target.files[0];
    },
  },
  watch: {
    userSelected: {
      handler(newUser, oldUser) {
        if (newUser != oldUser) {
          this.messageContent = "";
          this.image = null;
          this.$refs.inputFile.value = null;
        }
      },
    },
  },
};
</script>

<template>
  <div class="d-flex align-items-end justify-content-center gap-2 mt-2">
    <div>
      <input
        type="text"
        class="form-control form-control-sm input-text"
        v-model="messageContent"
        placeholder="Invia un messaggio"
      />
    </div>
    <div>
      <input
        type="file"
        @change="onFileSelected"
        class="form-control form-control-sm d-none"
        ref="inputFile"
        @keydown.enter="sendMessage"
      />
      <button
        :class="
          image != null
            ? 'btn btn-sm btn-success'
            : 'btn btn-sm btn-outline-secondary'
        "
        class="rounded-circle"
        @click="$refs.inputFile.click()"
      >
        <i class="bi bi-images"></i>
      </button>
    </div>
    <div>
      <button class="btn btn-sm btn-outline-success rounded-circle" @click="sendMessage">
        <i class="bi bi-send"></i>
      </button>
    </div>
  </div>
</template>

<style>
.input-text {
  width: 30em;
}
</style>