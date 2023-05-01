<script>
export default {
    props: ['currentUser'],
    data() {
        return {
            currentUserState: JSON.parse(this.currentUser),
            users: [],
        }
    }
}
</script>

<template>
    
</template>