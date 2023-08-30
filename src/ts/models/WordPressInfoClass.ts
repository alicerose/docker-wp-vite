export class WordPressInfoClass {

    private readonly classList: string[];

    public initialized = false;

    public type: {[s:string]: boolean};

    public state: {[s:string]: boolean};

    public id: number|null;

    public page: number|null;

    public postType: string|null;

    public template: string|null;

    constructor(classList: string[]) {

        this.classList = classList;

        this.id = null;
        this.page = null;
        this.postType = null;
        this.template = null;

        this.type = {
            home    : false,
            archive : false,
            tag     : false,
            category: false,
            page    : false,
            error404: false,
        };

        this.state = {
            logged_in: false,
            admin_bar: false,
            paged    : false,
        };

        this.defineTypes();

        this.initialized = true;
    }

    private defineTypes() {
        for(const cls of this.classList) {
            switch(cls) {
                case 'home':
                    this.type.home = true;
                    break;
                case 'single':
                    this.type.single = true;
                    break;
                case 'archive':
                    this.type.archive = true;
                    break;
                case 'category':
                    this.type.category = true;
                    break;
                case 'tag':
                    this.type.tag = true;
                    break;
                case 'page':
                    this.type.page = true;
                    break;
                case 'error404':
                    this.type.error404 = true;
                    break;

                case 'paged':
                    this.state.paged = true;
                    break;
                case 'logged-in':
                    this.state.logged_in = true;
                    break;
                case 'admin-bar':
                    this.state.admin_bar = true;
                    break;
            }

            this.defineId(cls);
            this.definePageNumber(cls);
            this.definePostType(cls);
            this.defineTemplate(cls);
        }
    }

    private defineId(cls: string) {
        if(cls.indexOf('id-') !== -1) {
            this.id = Number(cls.split('id-')[1]);
        }
    }

    private definePageNumber(cls: string) {
        if(cls.indexOf('paged-') !== -1) {
            this.page = Number(cls.split('paged-')[1]);
        }
    }

    private definePostType(cls: string) {
        if(cls.indexOf('single-') === 0) {
            this.postType = cls.replace('single-', '');
        }
    }

    private defineTemplate(cls: string) {
        if(cls.indexOf('page-template-page-') === 0) {
            this.template = cls.replace('page-template-page-', '');
        } else if(cls.indexOf('-template-') !== -1) {
            this.template = cls.split('-template-')[1];
        }
    }
}
