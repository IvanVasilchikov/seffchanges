require('./office-item.scss');
import cPicture from '../../core/picture/picture';
import cBtn from '../../core/btn/btn';
import popupEvent from '../../../base/scripts/popupEvent';

const template = require('./office-item.pug');

export default template({
    components: {
        cPicture,
        cBtn
    },
    methods: {
        popupOpen(type, name, info) {
            const object = {
                hidden: Object.assign({}, info),
            };
            popupEvent.open(type, name, object);
        },
    },
    props: ['info', 'className', 'isLazy'],
});
