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
  mounted() {
    this.getMessages();
  },
};
</script>

<template>
  <div>
    <p v-for="message in messages" :key="message.id">{{ message.message }}</p>
    <chat-box :currentAuthUser="currentAuthUser" :userSelected="userSelected"></chat-box>
  </div>
</template>

