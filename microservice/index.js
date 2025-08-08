const express = require('express');
const cors = require('cors');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(express.json());

// Mock data for external service
const mockData = [
    { id: 1, service: 'auth-service', status: 'active', version: '1.0.0' },
    { id: 2, service: 'user-service', status: 'active', version: '1.2.0' },
    { id: 3, service: 'notification-service', status: 'maintenance', version: '0.9.5' }
];

// Routes
app.get('/health', (req, res) => {
    res.json({
        status: 'ok',
        service: 'microservice-node',
        timestamp: new Date().toISOString(),
        uptime: process.uptime()
    });
});

app.get('/services', (req, res) => {
    res.json({
        success: true,
        data: mockData,
        message: 'Services retrieved successfully'
    });
});

app.get('/services/:id', (req, res) => {
    const id = parseInt(req.params.id);
    const service = mockData.find(s => s.id === id);
    
    if (!service) {
        return res.status(404).json({
            success: false,
            message: 'Service not found'
        });
    }
    
    res.json({
        success: true,
        data: service,
        message: 'Service retrieved successfully'
    });
});

// Mock endpoint for user validation
app.post('/validate-user', (req, res) => {
    const { email } = req.body;
    
    if (!email) {
        return res.status(400).json({
            success: false,
            message: 'Email is required'
        });
    }
    
    // Mock validation logic
    const isValid = email.includes('@') && email.includes('.');
    
    res.json({
        success: true,
        data: {
            email: email,
            isValid: isValid,
            risk_score: Math.random() * 100,
            timestamp: new Date().toISOString()
        },
        message: 'User validation completed'
    });
});

// Error handling middleware
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({
        success: false,
        message: 'Internal server error'
    });
});

// 404 handler
app.use('*', (req, res) => {
    res.status(404).json({
        success: false,
        message: 'Route not found'
    });
});

app.listen(PORT, () => {
    console.log(`Microservice running on port ${PORT}`);
    console.log(`Health check: http://localhost:${PORT}/health`);
    console.log(`Services: http://localhost:${PORT}/services`);
});
