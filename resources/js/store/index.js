import { createStore } from 'vuex'

import error from './error'
import message from './message'

const store = createStore({
  modules: {
    error,
    message
  }
})

export default store