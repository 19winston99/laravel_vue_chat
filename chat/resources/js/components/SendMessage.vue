<script>
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
  props: ["currentAuthUser", "userSelected"],
  emits: ["send-message"],
  data() {
    return {
      messageContent: "",
      image: null,
      typing: false,
      typingTimeOut: "",
      currentTypingUser: null,
      emoticons: [
        "❤",
        "😀",
        "😁",
        "😂",
        "🤣",
        "😃",
        "😄",
        "😅",
        "😆",
        "😉",
        "😊",
        "😋",
        "😎",
        "😍",
        "😘",
        "😗",
        "😙",
        "😚",
        "🙂",
        "🤗",
        "🤩",
        "🤔",
        "🤨",
        "😐",
        "😑",
        "😶",
        "🙄",
        "😏",
        "😣",
        "😥",
        "😮",
        "🤐",
        "😯",
        "😪",
        "😫",
        "😴",
        "😌",
        "😛",
        "😜",
        "😝",
        "🤤",
        "😒",
        "😓",
        "😔",
        "😕",
        "🙃",
        "🤑",
        "😲",
        "☹",
        "🙁",
        "😖",
        "😞",
        "😟",
        "😤",
        "😢",
        "😭",
        "😦",
        "😧",
        "😨",
        "😩",
        "🤯",
        "😬",
        "😰",
        "😱",
        "😳",
        "🤪",
        "😵",
        "😡",
        "😠",
        "🤬",
        "😷",
        "🤒",
        "🤕",
        "🤢",
        "🤮",
        "🤧",
        "😇",
        "🤠",
        "🤡",
        "🤥",
        "🤫",
        "🤭",
        "🧐",
        "🤓",
        "😈",
        "👿",
        "👹",
        "👺",
        "💀",
        "👻",
        "👽",
        "🤖",
        "💩",
      ],
    };
  },
  methods: {
    sendMessage() {
      if (this.messageContent || this.image) {
        toast.loading("Invio messaggio in corso...");
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
            toast.remove();
          }
        });
      }
    },
    onFileSelected(event) {
      this.image = event.target.files[0];
    },
    insertEmoticon(emoticon, event) {
      this.messageContent += emoticon;
      event.stopPropagation();
    },
    isTyping() {
      let channel = Echo.private("chat");
      setTimeout(() => {
        channel.whisper("typing", {
          user: this.userSelected.id,
          typing: true,
        });
      }, 300);
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
  mounted() {
    let _this = this;

    Echo.private("chat").listenForWhisper("typing", (e) => {
      this.currentTypingUser = e.user;
      this.typing = e.typing;
      clearTimeout(this.typingTimeOut);
      this.typingTimeOut = setTimeout(() => {
        _this.typing = false;
      }, 900);
    });
  },
};
</script>

<template>
  <div class="d-flex justify-content-center gap-2 mt-2">
    <div class="btn-group">
      <button
        class="btn btn-primary rounded-2 btn-sm dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        <i class="bi bi-emoji-smile-fill"></i>
      </button>
      <ul class="dropdown-menu drop-menu">
        <li
          v-for="emoticon in emoticons"
          class="dropdown-item drop-item"
          @click="insertEmoticon(emoticon, $event)"
          :key="emoticon.key"
        >
          {{ emoticon }}
        </li>
      </ul>
    </div>
    <div>
      <input
        type="text"
        class="form-control form-control-sm input-text"
        v-model="messageContent"
        placeholder="Invia un messaggio"
        @keydown.enter="sendMessage"
        @input="isTyping"
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
      <button
        class="btn btn-sm btn-outline-success rounded-circle"
        @click="sendMessage"
      >
        <i class="bi bi-send"></i>
      </button>
    </div>
  </div>
  <small
    v-if="typing && currentTypingUser == currentAuthUser.id"
    style="font-style: italic"
  >
    Sta scrivendo...
  </small>
</template>

<style>
.input-text {
  width: 30em;
  box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.5);
}

.drop-menu {
  height: 10em;
  overflow-y: scroll;
}

.drop-menu::-webkit-scrollbar {
  width: 12px;
}

.drop-menu::-webkit-scrollbar-track {
  background: #ccc;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}

.drop-menu::-webkit-scrollbar-thumb {
  background: #252cc525;
  border-radius: 10px;
}

.dropdown-item:hover {
  cursor: pointer;
}

.drop-item {
  outline: none;
  user-select: none;
}

@media screen and (max-width: 500px) {
  .input-text {
    width: 14em;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.5);
  }
}
</style>