import { motion } from 'motion/react';
import { Package, Clock, CheckCircle, XCircle, ChevronDown } from 'lucide-react';
import { Card, CardBody, CardHeader } from '../components/Card';
import { Badge } from '../components/Badge';
import { formatPrice } from '../data/products';
import { useState } from 'react';

interface Order {
  id: string;
  date: string;
  status: 'pending' | 'processing' | 'shipped' | 'delivered' | 'cancelled';
  items: number;
  total: number;
  tracking?: string;
}

const mockOrders: Order[] = [
  {
    id: 'ORD-2026-0421',
    date: '2026-04-21',
    status: 'delivered',
    items: 3,
    total: 445000,
    tracking: 'JNE123456789',
  },
  {
    id: 'ORD-2026-0418',
    date: '2026-04-18',
    status: 'shipped',
    items: 2,
    total: 210000,
    tracking: 'JNE987654321',
  },
  {
    id: 'ORD-2026-0415',
    date: '2026-04-15',
    status: 'processing',
    items: 5,
    total: 678000,
  },
  {
    id: 'ORD-2026-0410',
    date: '2026-04-10',
    status: 'delivered',
    items: 1,
    total: 175000,
    tracking: 'JNE456789123',
  },
];

export function OrdersPage() {
  const [expandedOrder, setExpandedOrder] = useState<string | null>(null);

  const getStatusColor = (status: Order['status']) => {
    switch (status) {
      case 'delivered':
        return 'success';
      case 'shipped':
        return 'primary';
      case 'processing':
        return 'warning';
      case 'cancelled':
        return 'danger';
      default:
        return 'secondary';
    }
  };

  const getStatusIcon = (status: Order['status']) => {
    switch (status) {
      case 'delivered':
        return CheckCircle;
      case 'shipped':
      case 'processing':
        return Clock;
      case 'cancelled':
        return XCircle;
      default:
        return Package;
    }
  };

  return (
    <div className="min-h-screen py-8">
      <div className="container mx-auto px-4 lg:px-8 max-w-5xl">
        <motion.h1
          className="font-black text-5xl md:text-7xl mb-8 uppercase"
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
        >
          Order <span className="text-[#FF0000]">History</span>
        </motion.h1>

        <div className="space-y-4">
          {mockOrders.map((order, index) => {
            const StatusIcon = getStatusIcon(order.status);
            const isExpanded = expandedOrder === order.id;

            return (
              <motion.div
                key={order.id}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4, delay: index * 0.1 }}
              >
                <Card hover className="border-2">
                  <CardHeader
                    className="cursor-pointer hover:bg-muted/30 transition-colors"
                    onClick={() => setExpandedOrder(isExpanded ? null : order.id)}
                  >
                    <div className="flex items-center justify-between">
                      <div className="flex items-center gap-4">
                        <div className="p-3 rounded-[2px] border-2 border-border">
                          <StatusIcon className="w-6 h-6 text-[#FF0000]" />
                        </div>
                        <div>
                          <p className="font-mono font-black text-lg">{order.id}</p>
                          <p className="font-mono text-sm text-muted-foreground">
                            {new Date(order.date).toLocaleDateString('id-ID', {
                              day: 'numeric',
                              month: 'long',
                              year: 'numeric',
                            })}
                          </p>
                        </div>
                      </div>

                      <div className="flex items-center gap-4">
                        <div className="text-right hidden md:block">
                          <p className="font-mono text-sm text-muted-foreground mb-1">
                            {order.items} items
                          </p>
                          <p className="font-black text-xl">{formatPrice(order.total)}</p>
                        </div>
                        <Badge variant={getStatusColor(order.status)}>
                          {order.status.toUpperCase()}
                        </Badge>
                        <motion.div
                          animate={{ rotate: isExpanded ? 180 : 0 }}
                          transition={{ duration: 0.3 }}
                        >
                          <ChevronDown className="w-5 h-5" />
                        </motion.div>
                      </div>
                    </div>
                  </CardHeader>

                  {isExpanded && (
                    <motion.div
                      initial={{ height: 0, opacity: 0 }}
                      animate={{ height: 'auto', opacity: 1 }}
                      exit={{ height: 0, opacity: 0 }}
                      transition={{ duration: 0.3 }}
                    >
                      <CardBody className="border-t-2 border-border space-y-4">
                        <div className="grid md:grid-cols-2 gap-6">
                          <div>
                            <p className="font-mono text-sm text-muted-foreground mb-2 uppercase tracking-wider">
                              Order Details
                            </p>
                            <div className="space-y-2 font-mono text-sm">
                              <div className="flex justify-between">
                                <span className="text-muted-foreground">Items</span>
                                <span className="font-black">{order.items} products</span>
                              </div>
                              <div className="flex justify-between">
                                <span className="text-muted-foreground">Total</span>
                                <span className="font-black">{formatPrice(order.total)}</span>
                              </div>
                              <div className="flex justify-between">
                                <span className="text-muted-foreground">Status</span>
                                <Badge variant={getStatusColor(order.status)}>
                                  {order.status}
                                </Badge>
                              </div>
                            </div>
                          </div>

                          {order.tracking && (
                            <div>
                              <p className="font-mono text-sm text-muted-foreground mb-2 uppercase tracking-wider">
                                Tracking
                              </p>
                              <div className="p-4 bg-muted/30 rounded-[2px] border border-border">
                                <p className="font-mono text-sm text-muted-foreground mb-1">
                                  Tracking Number
                                </p>
                                <p className="font-mono font-black text-lg">{order.tracking}</p>
                              </div>
                            </div>
                          )}
                        </div>

                        <div className="pt-4 border-t border-border">
                          <p className="font-mono text-xs text-muted-foreground">
                            Need help with this order? Contact our support team.
                          </p>
                        </div>
                      </CardBody>
                    </motion.div>
                  )}
                </Card>
              </motion.div>
            );
          })}
        </div>

        {mockOrders.length === 0 && (
          <div className="text-center py-20">
            <motion.div
              initial={{ scale: 0 }}
              animate={{ scale: 1 }}
              transition={{ duration: 0.5 }}
              className="inline-flex p-8 rounded-[2px] border-2 border-border mb-6"
            >
              <Package className="w-16 h-16 text-muted-foreground" />
            </motion.div>
            <h2 className="font-black text-3xl mb-4 uppercase">No Orders Yet</h2>
            <p className="text-muted-foreground font-mono mb-8">
              Start shopping to see your orders here
            </p>
          </div>
        )}
      </div>
    </div>
  );
}
