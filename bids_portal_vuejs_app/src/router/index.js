import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/views/Home.vue";
import Federal from "@/views/bids/Federal.vue";
import State from "@/views/bids/State.vue";
import Private from "@/views/bids/Private.vue";
import International from "@/views/bids/International.vue";
import Document from "@/views/bids/Document.vue";
import BidsDetailsPage from '@/views/bids/BidsDetailsPage.vue'
import BidsDetailsPage1 from '@/views/bids/BidsDetailsPage.vue'
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
import SaveAlert from "@/views/bids/SaveAlert";
import Profile from "@/views/auth/Profile"
import CreateBidAlert from '@/views/bids/BidsAlert'
import Plans_pricing from "@/views/Plans_pricing.vue";
import Feedback from "@/views/Feedback"
import PlanSubscription from "@/views/plans/PlanSubscription"
import ChangePassword from '@/views/users/ChangePassword'
import Subscription_payment from '@/views/payment/Subscription_payment'
import Normal_payment from '@/views/payment/NormalPayment'
import Reset_password from '@/views/auth/ResetPassword'
import Payment_failure from '@/views/payment/Payment_failure'

import PlansPricingNew from "@/views/PlansPricingNew.vue";

import Test from "@/views/Test.vue";

const routes = [
	{
		path: "/", name: "home",
		component: Home,
	},
	
	{
		path: "/bids/save-alert", name: "saveAlert",
		component: SaveAlert,
	},
	{
		path: "/cart", name: "Cart",
		component: Cart,
	},
	{
        path:'/subscription-payment/:item_number/:amount/:txn_id',
        name:'Subscription_payment',
        component:Subscription_payment
    },
	{
        path:'/payment-failure',
        name:'Payment_failure',
        component:Payment_failure
    },
	{
        path:'/normal-payment/:txn_id/:order_id/:payment_date/:first_name/:item_code/:payment_amount',
        name:'Normal_payment',
        component:Normal_payment
    },
	{
         
        path:'/bids/bid-alert/:region_id/Create',
        name:'CreateBidAlert',
        component:CreateBidAlert
    },
	{
		path:'/bids/bid-alert/:id/:region_id/edit',
	   name:'EditBidAlert',
	   component:CreateBidAlert
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
        path:'/reset-password/:fp_code/:email',
        name:Reset_password,
        component:Reset_password
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
		path: "/bids/federal-opportunities", name: "federalOpportunities",
		component: Federal,
	},
	{
		path: "/bids/:tdr_region/:tdr_id", name: "bidsDetailsPage",
		component: BidsDetailsPage,
	},
	{
		path: "/bids/:tdr_region/:tdr_id/:id", name: "bidsDetailsPageOutside",
		component: BidsDetailsPage,
	},
	{
		
		path: "/bids/bids-details-page/:tdr_id", name: "bidsDetailsPage1",
		component: BidsDetailsPage1,
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
		path: "/bids/state-opportunities", name: "stateOpportunities",
		component: State,
	},
	{
		path: "/bids/private", name: "private",
		component: Private,
	},
	{
		path: "/bids/private-commercial", name: "privateCommercial",
		component: Private,
	},
	{
		path: "/bids/international", name: "international",
		component: International,
	},
	{
		path: "/bids/international-opportunities", name: "internationalOpportunities",
		component: International,
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
        path: "/plans_pricing", name: "Plans_pricing",
        component: Plans_pricing,
    },
	{
        path:'/plans_pricing/:id',
        name:'PlanAcitve',
        component:Plans_pricing
    },

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
		path: "/plan_subscription/:id", name: "PlanSubscription",
        component: PlanSubscription,
	},

	{
		path: "/test", name: "Test",
        component: Test,
	},
	

];

const router = createRouter({
	history: createWebHashHistory(),
	routes,
});

export default router;
