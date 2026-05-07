import { motion } from 'motion/react';
import { TrendingUp, Package, Users, DollarSign, Activity } from 'lucide-react';
import { Card, CardBody, CardHeader } from '../components/Card';
import { Badge } from '../components/Badge';
import { formatPrice } from '../data/products';
import {
  LineChart,
  Line,
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from 'recharts';

const revenueData = [
  { month: 'Jan', revenue: 45000000, orders: 234 },
  { month: 'Feb', revenue: 52000000, orders: 287 },
  { month: 'Mar', revenue: 48000000, orders: 256 },
  { month: 'Apr', revenue: 61000000, orders: 312 },
  { month: 'May', revenue: 55000000, orders: 289 },
];

const categoryData = [
  { category: 'MCU', sales: 127 },
  { category: 'Sensors', sales: 284 },
  { category: 'Display', sales: 95 },
  { category: 'Comm', sales: 68 },
];

const stats = [
  {
    title: 'Total Revenue',
    value: formatPrice(261000000),
    change: '+12.5%',
    icon: DollarSign,
    trend: 'up',
  },
  {
    title: 'Total Orders',
    value: '1,378',
    change: '+8.2%',
    icon: Package,
    trend: 'up',
  },
  {
    title: 'Active Users',
    value: '2,847',
    change: '+15.3%',
    icon: Users,
    trend: 'up',
  },
  {
    title: 'Conversion Rate',
    value: '3.24%',
    change: '-2.1%',
    icon: Activity,
    trend: 'down',
  },
];

export function AdminPage() {
  return (
    <div className="min-h-screen py-8">
      <div className="container mx-auto px-4 lg:px-8">
        <motion.div
          className="mb-8"
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
        >
          <h1 className="font-black text-5xl md:text-7xl mb-2 uppercase">
            Admin <span className="text-[#FF0000]">Dashboard</span>
          </h1>
          <p className="font-mono text-muted-foreground">
            CONTROL PANEL / SYSTEM OVERVIEW
          </p>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          {stats.map((stat, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 40 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: index * 0.1 }}
            >
              <Card hover className="border-2">
                <CardBody>
                  <div className="flex items-start justify-between mb-4">
                    <div className="p-3 rounded-[2px] border-2 border-border">
                      <stat.icon className="w-6 h-6 text-[#FF0000]" />
                    </div>
                    <Badge variant={stat.trend === 'up' ? 'success' : 'danger'}>
                      {stat.change}
                    </Badge>
                  </div>
                  <p className="font-mono text-sm text-muted-foreground uppercase tracking-wider mb-2">
                    {stat.title}
                  </p>
                  <p className="font-black text-3xl">{stat.value}</p>
                </CardBody>
              </Card>
            </motion.div>
          ))}
        </div>

        <div className="grid lg:grid-cols-2 gap-6 mb-8">
          <motion.div
            initial={{ opacity: 0, x: -40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            <Card className="border-2">
              <CardHeader className="border-b-2 border-border">
                <div className="flex items-center justify-between">
                  <h2 className="font-black uppercase flex items-center gap-3">
                    <TrendingUp className="w-5 h-5 text-[#FF0000]" />
                    Revenue Overview
                  </h2>
                  <Badge variant="outline" className="font-mono">
                    5 MONTHS
                  </Badge>
                </div>
              </CardHeader>
              <CardBody>
                <ResponsiveContainer width="100%" height={300}>
                  <LineChart data={revenueData}>
                    <CartesianGrid
                      strokeDasharray="3 3"
                      stroke="rgba(255, 255, 255, 0.1)"
                      vertical={false}
                    />
                    <XAxis
                      dataKey="month"
                      stroke="rgba(255, 255, 255, 0.5)"
                      tick={{ fill: 'rgba(255, 255, 255, 0.7)', fontFamily: 'JetBrains Mono' }}
                    />
                    <YAxis
                      stroke="rgba(255, 255, 255, 0.5)"
                      tick={{ fill: 'rgba(255, 255, 255, 0.7)', fontFamily: 'JetBrains Mono' }}
                      tickFormatter={(value) => `${value / 1000000}M`}
                    />
                    <Tooltip
                      contentStyle={{
                        backgroundColor: '#0a0a0a',
                        border: '1px solid rgba(255, 255, 255, 0.1)',
                        borderRadius: '2px',
                        fontFamily: 'JetBrains Mono',
                      }}
                      formatter={(value: any) => formatPrice(value)}
                    />
                    <Line
                      type="monotone"
                      dataKey="revenue"
                      stroke="#FF0000"
                      strokeWidth={3}
                      dot={{ fill: '#FF0000', r: 6 }}
                      activeDot={{ r: 8 }}
                    />
                  </LineChart>
                </ResponsiveContainer>
              </CardBody>
            </Card>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            <Card className="border-2">
              <CardHeader className="border-b-2 border-border">
                <div className="flex items-center justify-between">
                  <h2 className="font-black uppercase flex items-center gap-3">
                    <Package className="w-5 h-5 text-[#FF0000]" />
                    Sales by Category
                  </h2>
                  <Badge variant="outline" className="font-mono">
                    CURRENT MONTH
                  </Badge>
                </div>
              </CardHeader>
              <CardBody>
                <ResponsiveContainer width="100%" height={300}>
                  <BarChart data={categoryData}>
                    <CartesianGrid
                      strokeDasharray="3 3"
                      stroke="rgba(255, 255, 255, 0.1)"
                      vertical={false}
                    />
                    <XAxis
                      dataKey="category"
                      stroke="rgba(255, 255, 255, 0.5)"
                      tick={{ fill: 'rgba(255, 255, 255, 0.7)', fontFamily: 'JetBrains Mono' }}
                    />
                    <YAxis
                      stroke="rgba(255, 255, 255, 0.5)"
                      tick={{ fill: 'rgba(255, 255, 255, 0.7)', fontFamily: 'JetBrains Mono' }}
                    />
                    <Tooltip
                      contentStyle={{
                        backgroundColor: '#0a0a0a',
                        border: '1px solid rgba(255, 255, 255, 0.1)',
                        borderRadius: '2px',
                        fontFamily: 'JetBrains Mono',
                      }}
                    />
                    <Bar dataKey="sales" fill="#FF0000" radius={[2, 2, 0, 0]} />
                  </BarChart>
                </ResponsiveContainer>
              </CardBody>
            </Card>
          </motion.div>
        </div>

        <motion.div
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.3 }}
        >
          <Card className="border-2">
            <CardHeader className="border-b-2 border-border">
              <h2 className="font-black uppercase">System Status</h2>
            </CardHeader>
            <CardBody>
              <div className="grid md:grid-cols-3 gap-6">
                <div className="p-4 bg-muted/20 rounded-[2px] border border-border">
                  <div className="flex items-center justify-between mb-2">
                    <span className="font-mono text-sm text-muted-foreground uppercase">
                      Server Status
                    </span>
                    <Badge variant="success">ONLINE</Badge>
                  </div>
                  <p className="font-mono text-xs text-muted-foreground">
                    Uptime: 99.98%
                  </p>
                </div>

                <div className="p-4 bg-muted/20 rounded-[2px] border border-border">
                  <div className="flex items-center justify-between mb-2">
                    <span className="font-mono text-sm text-muted-foreground uppercase">
                      Database
                    </span>
                    <Badge variant="success">ACTIVE</Badge>
                  </div>
                  <p className="font-mono text-xs text-muted-foreground">
                    Response: 12ms avg
                  </p>
                </div>

                <div className="p-4 bg-muted/20 rounded-[2px] border border-border">
                  <div className="flex items-center justify-between mb-2">
                    <span className="font-mono text-sm text-muted-foreground uppercase">
                      API Status
                    </span>
                    <Badge variant="success">OPERATIONAL</Badge>
                  </div>
                  <p className="font-mono text-xs text-muted-foreground">
                    Requests: 2.4K/min
                  </p>
                </div>
              </div>
            </CardBody>
          </Card>
        </motion.div>
      </div>
    </div>
  );
}
