// @ts-nocheck
export const PageInfo = {
  type: {
    single : false,
    column : false,
    article: false,
    archive: false,
    page   : false,
    contact: false,
  },

  stats: {
    logged_in: false,
    admin_bar: false,
  },

  init() {
    const bodyClass = $('body').attr('class').split(' ');
    for (const cls of bodyClass) {
      if (this.type[cls] === false) this.type[cls] = true;
      if (cls === 'single-post') this.type.column = true;
      if (cls === 'single-article') this.type.article = true;
      if (cls === 'logged-in') this.stats.logged_in = true;
      if (cls === 'admin-bar') this.stats.admin_bar = true;
    }
    console.log(this.type, this.stats);
  },
};
