from django.contrib import admin
from .models import Category, Product, Contact, Order, OrderItem, CartItem

admin.site.register(Category)
admin.site.register(Product)
admin.site.register(Contact)
admin.site.register(Order)
admin.site.register(OrderItem)
admin.site.register(CartItem)
