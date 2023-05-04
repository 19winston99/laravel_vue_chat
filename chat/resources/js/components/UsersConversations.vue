<script>
export default {
    props: ['conversations'],
}
</script>

<template>
    <small v-for="conversation in conversations" :key="conversation.id">
        {{ conversation.name }}
    </small>
</template>