<template>
  <header class="header">
    <div class="navbar__brand" @click="scrollTop">
      DVDリスト
    </div>
    <div class="hamburger">
      <!-- ここからハンバーガーメニュー -->
      <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check"/>
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
        <div class="menu-content">
          <ul>
            <li>
              <RouterLink class="button" to="/" @click="closeMenu">
                <i class="fas fa-list-ul fa-fw"></i>リスト
              </RouterLink>
            </li>

            <li>
              <RouterLink class="button" to="/create" @click="closeMenu">
                <i class="fas fa-plus fa-fw"></i>追加
              </RouterLink>
            </li>

            <li>
              <RouterLink class="button" to="/rent" @click="closeMenu">
                <i class="fas fa-user fa-fw"></i>貸出
              </RouterLink>
            </li>
          </ul>
        </div>
        <!-- ここまでハンバーガーメニュー -->
      </div>
    </div>
  </header>
</template>

<script>
export default {
  methods: {
    scrollTop: function(){
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    },

    closeMenu() {
      document.getElementById('menu-btn-check').checked = false;
    }
  }
}  
</script>