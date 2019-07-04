import BidsList from '../views/Catalog/views/BidsList.vue'
import BidDetail from '../views/Catalog/views/BidDetail.vue'

const routes = [
    {
        path: '/',
        name: 'bids.list',
        component: BidsList,
		meta: {
			breadcrumb: false,
			title: `${APPNAME} - Заявки`,
		},
    },
	{
        path: '/bids/:id',
        name: 'bids.detail',
        component: BidDetail,
		meta: {
			title: `${APPNAME} - Заявка`,
		},
    },
]

export default routes