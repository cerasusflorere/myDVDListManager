<template>
  <div class="overlay" @click.self="$emit('close')">
    <div class="dialog"  ref="message_dialog">
      <div class="message-button-area">
        <button type="button" @click="$emit('close')" class="message-button"><i class="fas fa-times fa-fw"></i></button>
      </div>
      <div>
{{ postMessage_Message }}
      </div>
      </div>
  </div>
</template>
  
<script>
  export default {
    // モーダルとして表示
    name: 'messageDialog',
    props: {
      postMessage_Message: {
        type: String,
        required: true
      }
    },

    data() {
      return {
        // overlayのクラス
        //overlay_class: 1
      }
    },
    watch: {
      // confirm_dialog_title: {
      //   async handler(confirm_dialog_edit_message) {
      //     const content_dom = this.$refs.content_confirm_dialog_edit;
      //     const content_rect = content_dom.getBoundingClientRect(); // 要素の座標と幅と高さを取得

      //     if(content_rect.top < 0){
      //       this.overlay_class = 0;
      //     }else{
      //       this.overlay_class = 1;
      //     }
      //   },
      //   immediate: true,
      // }
    }
  }
</script>