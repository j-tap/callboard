import CompaniesList from '../views/Companies/views/List'
import CompaniesDetail from '../views/Companies/views/Detail'

const routes = [
    {
        path: '/companies',
        name: 'companies.list',
        component: CompaniesList,
		meta: {
			title: `${APPNAME} - Список компаний`,
		},
    },
	{
        path: '/companies/:id',
        name: 'companies.detail',
        component: CompaniesDetail,
		meta: {
			title: `${APPNAME} - Страница компании`,
		},
    },
]

export default routes