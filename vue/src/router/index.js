import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/views/Home.vue";
import Federal from "@/views/bids/Federal.vue";
import State from "@/views/bids/State.vue";
import Private from "@/views/bids/Private.vue";
import International from "@/views/bids/International.vue";
import InternationalTenderDetails from '@/views/tender_details/International.vue'
import Document from "@/views/bids/Document.vue";
import FederalTenderDetails from '@/views/tender_details/Federal.vue'
import StateTenderDetails from '@/views/tender_details/State.vue'
import PrivateTenderDetails from '@/views/tender_details/Private.vue'
import BidsDetailsPage from '@/views/bids/BidsDetailsPage.vue'
// auth
import Login from "@/views/auth/Login.vue";
import SignUp from "@/views/auth/SignUp.vue";
import ForgotPassword from "@/views/auth/ForgotPassword.vue";

// contact
import Contact_us from "@/views/Contact_us.vue";
import Contact_us_new from "@/views/ContactUsNew.vue";

// about us
import AboutUs from "@/views/AboutUs.vue";

// Faq's
import Faq from "@/views/Faq.vue";

// Terms&condition
import Termscondition from "@/views/Terms&condition.vue";

// Privacy Policy
import PrivacyPolicy from "@/views/PrivacyPolicy.vue";
// cart
import Cart from "@/views/cart/AddToCart"

// Disclaimer Email Policy
import DisclaimerEmailPolicy from "@/views/DisclaimerEmailPolicy.vue";
import Subscription from '@/views/users/Subscription';
import SingleBidPurchases from '@/views/users/SingleBidPurchases';

import MyPurchasedBids from '@/views/users/MyPurchasedBids'

import Profile from "@/views/auth/Profile"
import CreateBidAlert from '@/views/bids/BidsAlert'
import SubscriptionPlans from "@/views/subscriptions/SubscriptionPlan.vue";
import Feedback from "@/views/Feedback"
import PlanSubscription from "@/views/plans/PlanSubscription"
import ChangePassword from '@/views/users/ChangePassword'
import SubscriptionPayment from '@/views/payment/SubscriptionPayment'
import Normal_payment from '@/views/payment/NormalPayment'
import Reset_password from '@/views/auth/ResetPassword'
import Payment_failure from '@/views/payment/Payment_failure'

import PlansPricingNew from "@/views/PlansPricingNew.vue";

//Alerts
import Alert from "@/views/alerts/Index";
import StateAlert from "@/views/alerts/StateAlert";
import FederalAlert from "@/views/alerts/FederalAlert";
import PrivateAlert from "@/views/alerts/PrivateAlert";
import InternationalAlert from "@/views/alerts/InternationalAlert";


const routes = [
	{
		path: "/", name: "home",
		component: Home,
	},

	{
		path: "/bids/alerts", name: "Alert",
		component: Alert,
	},
	{
		path: '/bids/state_alert',
		name: 'StateAlert',
		component: StateAlert
	},

	{
		path: '/bids/State/:alert_id/edit',
		name: 'EditStateAlert',
		component: StateAlert
	},

	{
		path: '/bids/federal_alert',
		name: 'FederalAlert',
		component: FederalAlert
	},
	{
		path: '/bids/Federal/:alert_id/edit',
		name: 'EditFederalAlert',
		component: FederalAlert
	},

	{
		path: '/bids/private_alert',
		name: 'PrivateAlert',
		component: PrivateAlert
	},
	{
		path: '/bids/international_alert',
		name: 'InternationalAlert',
		component: InternationalAlert
	},
	{
		path: "/cart", name: "Cart",
		component: Cart,
	},
	{
		path: '/subscription-payment/:item_number/:amount/:txn_id/:valid_upto',
		name: 'SubscriptionPayment',
		component: SubscriptionPayment
	},
	{
		path: '/payment-failure',
		name: 'Payment_failure',
		component: Payment_failure
	},
	{
		path: '/normal-payment/:txn_id/:order_id/:payment_date/:first_name/:user_payment_id',
		name: 'Normal_payment',
		component: Normal_payment
	},
	{

		path: '/bids/bid-alert/:region/create',
		name: 'CreateBidAlert',
		component: CreateBidAlert
	},
	{
		path: '/bids/bid-alert/:region/:alert_id/edit',
		name: 'EditBidAlert',
		component: CreateBidAlert
	},
	{
		path: "/user/profile", name: "profile",
		component: Profile,
	},
	// user change password
	{
		path: "/user/change-password", name: "ChangePassword",
		component: ChangePassword,
	},
	{
		path: '/reset-password/:fp_code/:email',
		name: Reset_password,
		component: Reset_password
	},
	{
		path: "/user/single-bidpurchases", name: "singlebidpurchases",
		component: SingleBidPurchases,
	},
	{
		path: "/user/my-purchasedbids", name: "mypurchasedbids",
		component: MyPurchasedBids,
	},
	{
		path: "/user/subscription", name: "Subscription",
		component: Subscription,
	},
	{
		path: "/bids", name: "search",
		component: Federal
	},
	{
		path: "/bids/federal-opportunities", name: "federal_opportunities",
		component: Federal,
	},
	{
		path: "/bids/federal-opportunities/:tender_id", name: "federal_tender_details",
		component: FederalTenderDetails,
	},
	{
		path: "/bids/state-opportunities/:tender_id", name: "state_tender_details",
		component: StateTenderDetails,
	},
	{
		path: "/bids/private-commercial/:tender_id", name: "private_tender_details",
		component: PrivateTenderDetails,
	},
	{
		path: "/bids/:tdr_region/:tdr_id", name: "bidsDetailsPage",
		component: BidsDetailsPage,
	},
	{
		path: "/bids/:tdr_region/:tdr_id/:id", name: "bidsDetailsPageOutside",
		component: BidsDetailsPage,
	},

	// {

	// 	path: "/bids/:tdr_region/:tdr_id", name: "bidsDetailsPage",
	// 	component: BidsDetailsPage,
	// },
	{
		path: "/bids/state", name: "state",
		component: State,
	},
	{
		path: "/bids/state-opportunities", name: "state_opportunities",
		component: State,
	},
	{
		path: "/bids/private", name: "private",
		component: Private,
	},
	// {
	// 	path: "/bids/private-commercial-new", name: "private_opportunities",
	// 	component: Private,
	// },
	{
		path: "/bids/private-commercial", name: "private_opportunities",
		component: Private,
	},
	{
		path: "/bids/international", name: "international",
		component: International,
	},
	{
		path: "/bids/international-opportunities", name: "international_opportunities",
		component: International,
	},
	{
		path: "/bids/international-opportunities/:tender_id", name: "international_tender_details",
		component: InternationalTenderDetails,
	},
	{
		path: "/bids/documents", name: "documents",
		component: Document,
	},

	// auth
	{
		path: "/login", name: "Login",
		component: Login,
	},
	{
		path: "/sign_up", name: "SignUp",
		component: SignUp,
	},
	{
		path: "/forgot_password", name: "ForgotPassword",
		component: ForgotPassword,
	},

	// contact us
	{
		path: "/contact_us", name: "Contact_us",
		component: Contact_us,
	},

	{
		path: "/contact_us_new", name: "Contact_us_new",
		component: Contact_us_new,
	},

	//About us
	{
		path: "/about_us", name: "AboutUs",
		component: AboutUs,
	},

	// Faq
	{
		path: "/faq", name: "Faq",
		component: Faq,
	},
	// Terms and conditions
	{
		path: "/terms&condition", name: "Termscondition",
		component: Termscondition,
	},
	// Privacy Policy
	{
		path: "/privacy_policy", name: "PrivacyPolicy",
		component: PrivacyPolicy,
	},
	// Disclaimer and email Policy
	{
		path: "/disclaimer_email_policy", name: "DisclaimerEmailPolicy",
		component: DisclaimerEmailPolicy,
	},
	// Plans_pricing
	{
		path: "/subscription_plans", name: "SubscriptionPlans",
		component: SubscriptionPlans,
	},
	{
		path: "/subscription_plans/:id", name: "ActivateUser",
		component: SubscriptionPlans,
	},
	// {
	//     path:'/plans_pricing/:id',
	//     name:'PlanAcitve',
	//     component:Plans_pricing
	// },

	//plan pricing new
	{
		path: "/plansPricingNew", name: "PlansPricingNew",
		component: PlansPricingNew,
	},





	// Feedback
	{
		path: "/feedback", name: "Feedback",
		component: Feedback,
	},
	{
		path: "/plan_subscription", name: "PlanSubscription",
		component: PlanSubscription,
	}

];

const router = createRouter({
	history: createWebHashHistory(),
	routes,
});

export default router;
