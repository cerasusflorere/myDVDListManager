<template>
  <div class="overlay photo-overlay" @click.self="$emit('close')">
    <div class="dialog photo-dialog">
      <div class="message-button-area">
        <button type="button" @click="$emit('close')" class="message-button"><i class="fas fa-times fa-fw"></i></button>
      </div>
      <div class="photo-area">
        <figure class="photo-wrapper">
          <img
            class="photo-image"
            :src="postURL"
          >
        </figure>
      </div>
    </div>
  </div>
</template>
  
<script>
  export default {
    // モーダルとして表示
    name: 'photoDialog',
    props: {
      postURL: {
        type: String,
        required: true
      }
    }
  }
</script>