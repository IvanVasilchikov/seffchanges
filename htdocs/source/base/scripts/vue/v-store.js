import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'

if (window.vStore == undefined) {
  Vue.use(Vuex);
  const vStore = new Vuex.Store({
    plugins: [createPersistedState()],
    state: {
      favorite: [],
      mapFilter: {},
    },
    mutations: {
      toggleFavorite(state, id) {
        const index = this.state.favorite.indexOf(id);
        if (index < 0) {
          state.favorite.push(id);
        } else {
          state.favorite.splice(index, 1);
        }
      },
      removeAllFavorite(state) {
        state.favorite.splice(0);
      },
      saveFilter(state, obj) {
        if (state.mapFilter) {
          Vue.set(state, 'mapFilter', obj);
        }
      },
    },
    getters: {
      filterContains: state => id => {
        return (state.mapFilter.hasOwnProperty(id));
      },
      getFilterData: state => name => {
        return (state.mapFilter[`${name}`])
      },
    },
  });
  window.vStore = vStore;
}
export default window.vStore;
