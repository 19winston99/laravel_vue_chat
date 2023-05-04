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
  <div>
    <p v-for="message in messages" :key="message.id">{{ message.message }}</p>
    <send-message
      :currentAuthUser="currentAuthUser"
      :userSelected="userSelected"
    ></send-message>
  </div>
</template>

