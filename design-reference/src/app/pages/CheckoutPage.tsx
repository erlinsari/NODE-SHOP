import { useState } from 'react';
import { motion } from 'motion/react';
import { CreditCard, MapPin, User as UserIcon, Mail, Phone, CheckCircle } from 'lucide-react';
import { Button } from '../components/Button';
import { Card, CardBody, CardHeader } from '../components/Card';
import { Badge } from '../components/Badge';
import { formatPrice } from '../data/products';
import { CartItem } from './CartPage';

interface CheckoutPageProps {
  cartItems: CartItem[];
  onNavigate?: (page: string) => void;
  onPlaceOrder?: (orderData: any) => void;
}

export function CheckoutPage({ cartItems, onNavigate, onPlaceOrder }: CheckoutPageProps) {
  const [step, setStep] = useState<'shipping' | 'payment' | 'success'>('shipping');
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    postalCode: '',
    cardNumber: '',
    cardName: '',
    expiry: '',
    cvv: '',
  });

  const subtotal = cartItems.reduce(
    (sum, item) => sum + item.product.price * item.quantity,
    0
  );
  const shipping = subtotal > 500000 ? 0 : 25000;
  const tax = subtotal * 0.11;
  const total = subtotal + shipping + tax;

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmitShipping = (e: React.FormEvent) => {
    e.preventDefault();
    setStep('payment');
  };

  const handleSubmitPayment = (e: React.FormEvent) => {
    e.preventDefault();
    onPlaceOrder?.({ ...formData, cartItems, total });
    setStep('success');
  };

  if (step === 'success') {
    return (
      <div className="min-h-screen flex items-center justify-center py-8">
        <motion.div
          className="text-center max-w-md"
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.5 }}
        >
          <motion.div
            className="inline-flex p-8 rounded-[2px] border-2 border-[#FF0000] mb-6"
            initial={{ scale: 0 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.5, delay: 0.2 }}
          >
            <CheckCircle className="w-16 h-16 text-[#FF0000]" />
          </motion.div>

          <h2 className="font-black text-4xl mb-4 uppercase">
            Order <span className="text-[#FF0000]">Confirmed</span>
          </h2>

          <p className="text-muted-foreground font-mono mb-2">Order ID:</p>
          <p className="font-mono font-black text-2xl mb-8">
            #{Math.random().toString(36).substr(2, 9).toUpperCase()}
          </p>

          <Card className="mb-8 text-left">
            <CardBody className="space-y-3 font-mono text-sm">
              <div className="flex justify-between">
                <span className="text-muted-foreground">Total Amount</span>
                <span className="font-black">{formatPrice(total)}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-muted-foreground">Delivery To</span>
                <span className="font-black">{formData.name}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-muted-foreground">Email</span>
                <span className="font-black">{formData.email}</span>
              </div>
            </CardBody>
          </Card>

          <div className="space-y-4">
            <Button className="w-full" onClick={() => onNavigate?.('orders')}>
              View Order Status
            </Button>
            <Button variant="outline" className="w-full" onClick={() => onNavigate?.('home')}>
              Back to Home
            </Button>
          </div>
        </motion.div>
      </div>
    );
  }

  return (
    <div className="min-h-screen py-8">
      <div className="container mx-auto px-4 lg:px-8 max-w-6xl">
        <motion.h1
          className="font-black text-5xl md:text-7xl mb-8 uppercase"
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
        >
          Check<span className="text-[#FF0000]">out</span>
        </motion.h1>

        <div className="flex gap-4 mb-8">
          <Badge variant={step === 'shipping' ? 'primary' : 'outline'}>1. Shipping</Badge>
          <Badge variant={step === 'payment' ? 'primary' : 'outline'}>2. Payment</Badge>
        </div>

        <div className="grid lg:grid-cols-3 gap-8">
          <div className="lg:col-span-2">
            {step === 'shipping' && (
              <motion.div
                initial={{ opacity: 0, x: -20 }}
                animate={{ opacity: 1, x: 0 }}
                transition={{ duration: 0.5 }}
              >
                <Card>
                  <CardHeader>
                    <h2 className="font-black uppercase text-xl flex items-center gap-3">
                      <MapPin className="w-5 h-5 text-[#FF0000]" />
                      Shipping Information
                    </h2>
                  </CardHeader>
                  <CardBody>
                    <form onSubmit={handleSubmitShipping} className="space-y-4">
                      <div className="grid md:grid-cols-2 gap-4">
                        <div>
                          <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                            Full Name *
                          </label>
                          <div className="relative">
                            <UserIcon className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                            <input
                              type="text"
                              name="name"
                              required
                              value={formData.name}
                              onChange={handleInputChange}
                              className="w-full pl-10 pr-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                            />
                          </div>
                        </div>

                        <div>
                          <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                            Email *
                          </label>
                          <div className="relative">
                            <Mail className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                            <input
                              type="email"
                              name="email"
                              required
                              value={formData.email}
                              onChange={handleInputChange}
                              className="w-full pl-10 pr-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                            />
                          </div>
                        </div>
                      </div>

                      <div>
                        <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                          Phone Number *
                        </label>
                        <div className="relative">
                          <Phone className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                          <input
                            type="tel"
                            name="phone"
                            required
                            value={formData.phone}
                            onChange={handleInputChange}
                            className="w-full pl-10 pr-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                          />
                        </div>
                      </div>

                      <div>
                        <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                          Address *
                        </label>
                        <input
                          type="text"
                          name="address"
                          required
                          value={formData.address}
                          onChange={handleInputChange}
                          className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                        />
                      </div>

                      <div className="grid md:grid-cols-2 gap-4">
                        <div>
                          <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                            City *
                          </label>
                          <input
                            type="text"
                            name="city"
                            required
                            value={formData.city}
                            onChange={handleInputChange}
                            className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                          />
                        </div>

                        <div>
                          <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                            Postal Code *
                          </label>
                          <input
                            type="text"
                            name="postalCode"
                            required
                            value={formData.postalCode}
                            onChange={handleInputChange}
                            className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                          />
                        </div>
                      </div>

                      <div className="flex gap-4 pt-4">
                        <Button type="button" variant="outline" onClick={() => onNavigate?.('cart')}>
                          Back to Cart
                        </Button>
                        <Button type="submit" className="flex-1">
                          Continue to Payment
                        </Button>
                      </div>
                    </form>
                  </CardBody>
                </Card>
              </motion.div>
            )}

            {step === 'payment' && (
              <motion.div
                initial={{ opacity: 0, x: -20 }}
                animate={{ opacity: 1, x: 0 }}
                transition={{ duration: 0.5 }}
              >
                <Card>
                  <CardHeader>
                    <h2 className="font-black uppercase text-xl flex items-center gap-3">
                      <CreditCard className="w-5 h-5 text-[#FF0000]" />
                      Payment Details
                    </h2>
                  </CardHeader>
                  <CardBody>
                    <form onSubmit={handleSubmitPayment} className="space-y-4">
                      <div>
                        <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                          Card Number *
                        </label>
                        <input
                          type="text"
                          name="cardNumber"
                          required
                          placeholder="1234 5678 9012 3456"
                          value={formData.cardNumber}
                          onChange={handleInputChange}
                          maxLength={19}
                          className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                        />
                      </div>

                      <div>
                        <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                          Cardholder Name *
                        </label>
                        <input
                          type="text"
                          name="cardName"
                          required
                          value={formData.cardName}
                          onChange={handleInputChange}
                          className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                        />
                      </div>

                      <div className="grid grid-cols-2 gap-4">
                        <div>
                          <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                            Expiry Date *
                          </label>
                          <input
                            type="text"
                            name="expiry"
                            required
                            placeholder="MM/YY"
                            value={formData.expiry}
                            onChange={handleInputChange}
                            maxLength={5}
                            className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                          />
                        </div>

                        <div>
                          <label className="block font-mono text-sm mb-2 uppercase tracking-wider">
                            CVV *
                          </label>
                          <input
                            type="text"
                            name="cvv"
                            required
                            placeholder="123"
                            value={formData.cvv}
                            onChange={handleInputChange}
                            maxLength={3}
                            className="w-full px-4 py-3 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono"
                          />
                        </div>
                      </div>

                      <div className="flex gap-4 pt-4">
                        <Button type="button" variant="outline" onClick={() => setStep('shipping')}>
                          Back
                        </Button>
                        <Button type="submit" className="flex-1">
                          Place Order - {formatPrice(total)}
                        </Button>
                      </div>
                    </form>
                  </CardBody>
                </Card>
              </motion.div>
            )}
          </div>

          <motion.div
            className="lg:sticky lg:top-24 h-fit"
            initial={{ opacity: 0, x: 40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            <Card className="border-2">
              <CardHeader className="border-b-2 border-border">
                <h3 className="font-black uppercase">Order Summary</h3>
              </CardHeader>
              <CardBody className="space-y-4">
                {cartItems.map((item) => (
                  <div key={item.product.id} className="flex gap-3">
                    <img
                      src={item.product.image}
                      alt={item.product.name}
                      className="w-16 h-16 object-cover rounded-[2px]"
                    />
                    <div className="flex-1 min-w-0">
                      <p className="font-mono text-sm font-black truncate">
                        {item.product.name}
                      </p>
                      <p className="font-mono text-xs text-muted-foreground">
                        Qty: {item.quantity}
                      </p>
                      <p className="font-mono text-sm font-black">
                        {formatPrice(item.product.price * item.quantity)}
                      </p>
                    </div>
                  </div>
                ))}

                <div className="h-px bg-border my-4" />

                <div className="space-y-2 font-mono text-sm">
                  <div className="flex justify-between">
                    <span className="text-muted-foreground">Subtotal</span>
                    <span className="font-black">{formatPrice(subtotal)}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-muted-foreground">Shipping</span>
                    <span className="font-black">
                      {shipping === 0 ? <Badge variant="success">FREE</Badge> : formatPrice(shipping)}
                    </span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-muted-foreground">Tax</span>
                    <span className="font-black">{formatPrice(tax)}</span>
                  </div>
                </div>

                <div className="h-px bg-border my-4" />

                <div className="flex justify-between items-center">
                  <span className="font-black uppercase">Total</span>
                  <span className="text-2xl font-black">{formatPrice(total)}</span>
                </div>
              </CardBody>
            </Card>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
