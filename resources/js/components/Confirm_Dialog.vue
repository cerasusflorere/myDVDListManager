<template>
  <div class="overlay overlay-message" @click.self="$emit('Cancel')">
    <div class="dialog"  ref="content_confirm_dialog">
      <div class="message-button-area">
        <button type="button" @click="$emit('Cancel')" class="message-button"><i class="fas fa-times fa-fw"></i></button>
      </div>
      <div>
{{ postMessage_Confirm }}
      </div>
      <div class="confirm-dialog-message">
{{ postMessage_Confirm }}してよろしいですね？
      </div>

      <div class="confirm-button-area">
        <button type="button" @click="$emit('Cancel')" class="confirm-cancel-button"><i class="fas fa-ban fa-fw"></i>キャンセル</button>
        
        <button type="button" @click="$emit('OK')" class="confirm-do-button"><i class="fas fa-edit fa-fw"></i>{{ postMessage_Confirm }}</button>
      </div>  
      </div>
  </div>
</template>
  
<script>
  export default {
    // モーダルとして表示
    name: 'confirmDialog',
    props: {
      postMessage_Confirm: {
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
      // postMessage_Confirm: {
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
      // },
    }
  }
</script>