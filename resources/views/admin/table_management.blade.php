<!DOCTYPE html>
<html>
  <head> 
   @include('admin.css')

   <style>
         /* Main scroll area so nothing gets cut off by admin wrappers */
         .table-management-scroll {
          width: 100%;
          max-width: 100%;
          overflow: auto;            /* vertical + horizontal scrolling */
          max-height: calc(100vh - 120px);
          -webkit-overflow-scrolling: touch;
          padding-right: 8px;        /* room for scrollbar */
          box-sizing: border-box;
         }

         .table-management-container {
          margin: 20px auto;
          width: 100%;
          max-width: 100%;           /* allow full width */
          padding: 20px;
          box-sizing: border-box;
         }

         .page-title {
          text-align: center;
          color: #333;
          margin-bottom: 30px;
          font-size: 2.5em;
          font-weight: bold;
         }

         .management-tabs {
          display: flex;
          justify-content: center;
          margin-bottom: 30px;
          gap: 10px;
          flex-wrap: wrap;
         }

         .management-tab {
          padding: 12px 24px;
          background-color: #f8f9fa;
          border: 2px solid #dee2e6;
          border-radius: 25px;
          cursor: pointer;
          transition: all 0.3s ease;
          font-weight: bold;
         }

         .management-tab.active {
          background-color: #007bff;
          color: white;
          border-color: #007bff;
         }

         .management-tab:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 8px rgba(0,0,0,0.1);
         }

         .management-section {
          display: none;
         }

         .management-section.active {
          display: block;
         }

         .add-table-form {
          background: white;
          padding: 30px;
          border-radius: 15px;
          box-shadow: 0 4px 15px rgba(0,0,0,0.1);
          margin-bottom: 30px;
         }

         .form-row {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 20px;
          margin-bottom: 20px;
         }

         .form-group {
          display: flex;
          flex-direction: column;
         }

         .form-group label {
          font-weight: bold;
          margin-bottom: 5px;
          color: #333;
         }

         .form-group input, .form-group select {
          padding: 10px;
          border: 2px solid #dee2e6;
          border-radius: 8px;
          outline: none;
          transition: border-color 0.3s ease;
         }

         .form-group input:focus, .form-group select:focus {
          border-color: #007bff;
         }

         .btn-primary {
          background-color: #007bff;
          color: white;
          padding: 12px 24px;
          border: none;
          border-radius: 8px;
          cursor: pointer;
          font-weight: bold;
          transition: all 0.3s ease;
         }

         .btn-primary:hover {
          background-color: #0056b3;
          transform: translateY(-2px);
         }

         .btn-success {
          background-color: #28a745;
          color: white;
          padding: 8px 16px;
          border: none;
          border-radius: 6px;
          cursor: pointer;
          font-size: 0.9em;
         }

         .btn-danger {
          background-color: #dc3545;
          color: white;
          padding: 8px 16px;
          border: none;
          border-radius: 6px;
          cursor: pointer;
          font-size: 0.9em;
         }

         .btn-warning {
          background-color: #ffc107;
          color: #333;
          padding: 8px 16px;
          border: none;
          border-radius: 6px;
          cursor: pointer;
          font-size: 0.9em;
         }

         .tables-grid-admin {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 20px;
          margin-top: 20px;
         }

         .table-item-admin {
          background-color: #f8f9fa;
          border: 3px solid #6c757d;
          border-radius: 15px;
          padding: 20px;
          text-align: center;
          transition: all 0.3s ease;
          color: #333;
          position: relative;
         }

         .table-item-admin.available {
          border-color: #28a745;
          background-color: #d4edda;
         }

         .table-item-admin.reserved {
          border-color: #dc3545;
          background-color: #f8d7da;
         }


         .table-number-admin {
          font-size: 1.5em;
          font-weight: bold;
          margin-bottom: 10px;
         }

         .table-seats-admin {
          font-size: 1em;
          margin-bottom: 10px;
         }

         .table-status-admin {
          font-size: 0.9em;
          font-weight: bold;
          padding: 5px 10px;
          border-radius: 15px;
          margin-bottom: 15px;
         }

         .table-status-admin.available {
          background-color: #28a745;
          color: white;
         }

         .table-status-admin.reserved {
          background-color: #dc3545;
          color: white;
         }


         .table-actions {
          display: flex;
          gap: 5px;
          justify-content: center;
          flex-wrap: wrap;
         }

         .section-header {
          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
          color: white;
          padding: 15px;
          border-radius: 10px;
          margin-bottom: 20px;
          text-align: center;
          font-size: 1.2em;
          font-weight: bold;
         }

         .stats-overview {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
          gap: 15px;
          margin-bottom: 30px;
         }

         .stat-item {
          background: white;
          padding: 20px;
          border-radius: 10px;
          text-align: center;
          box-shadow: 0 2px 10px rgba(0,0,0,0.1);
         }

         .stat-number {
          font-size: 2em;
          font-weight: bold;
          margin-bottom: 5px;
         }

         .stat-label {
          font-size: 0.9em;
          color: #666;
         }

         .stat-item.total .stat-number { color: #007bff; }
         .stat-item.available .stat-number { color: #28a745; }
         .stat-item.reserved .stat-number { color: #dc3545; }
        
        /* Ensure key titles are readable against any theme background */
        .page-title {
          color: #fff !important;
          text-shadow: 0 1px 2px rgba(0,0,0,0.15);
        }
        .section-header {
          color: #ffffff !important;
        }
        /* Overview section headings */
        #overview-section h3 { color: #ffffff !important; }
        #overview-section h4 { color: #ffffff !important; }
        /* Tabs text contrast */
        .management-tab { color: #212529; }
        .management-tab.active { color: #ffffff; }
         
         /* Status Control Styles */
         .status-control {
           cursor: pointer;
           transition: all 0.3s ease;
           position: relative;
           overflow: hidden;
         }
         
         .status-control:hover {
           transform: scale(1.05);
           box-shadow: 0 8px 25px rgba(0,0,0,0.15);
         }
         
         .status-control.available:hover {
           background: linear-gradient(135deg, #28a745, #20c997);
         }
         
         .status-control.reserved:hover {
           background: linear-gradient(135deg, #dc3545, #fd7e14);
         }
         
         .status-indicator {
           position: absolute;
           top: 5px;
           right: 5px;
         }
         
         .status-dot {
           width: 12px;
           height: 12px;
           border-radius: 50%;
           display: inline-block;
         }
         
         .status-dot.available {
           background-color: #28a745;
           box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
         }
         
         .status-dot.reserved {
           background-color: #dc3545;
           box-shadow: 0 0 10px rgba(220, 53, 69, 0.5);
         }
         
         .status-control-info {
           background: #e3f2fd;
           padding: 15px;
           border-radius: 8px;
           margin-bottom: 20px;
           border-left: 4px solid #2196f3;
         }

         @media (max-width: 768px) {
          .management-tabs {
            flex-direction: column;
            align-items: center;
          }
          
          .form-row {
            grid-template-columns: 1fr;
          }
          
          .tables-grid-admin {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
          }
         }
   </style>
  </head>
  <body>
   
      @include('admin.header')

      @include('admin.sidebar')

      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <div class="table-management-scroll">
          <div class="table-management-container">
            <h1 class="page-title">Table Management System</h1>
            
            <!-- Statistics Overview -->
            <div class="stats-overview">
              <div class="stat-item total">
                <div class="stat-number" id="totalTables">33</div>
                <div class="stat-label">Total Tables</div>
              </div>
              <div class="stat-item available">
                <div class="stat-number" id="availableTables">25</div>
                <div class="stat-label">Available</div>
              </div>
              <div class="stat-item reserved">
                <div class="stat-number" id="reservedTables">8</div>
                <div class="stat-label">Reserved</div>
              </div>
            </div>

            <!-- Management Tabs -->
            <div class="management-tabs">
              <div class="management-tab active" data-section="overview">Overview</div>
              <div class="management-tab" data-section="add">Add Table</div>
              <div class="management-tab" data-section="edit">Edit Tables</div>
              <div class="management-tab" data-section="capacity">Seat Capacity</div>
              <div class="management-tab" data-section="sections">Manage Sections</div>
            </div>

            <!-- Overview Section -->
            <div id="overview-section" class="management-section active">
              <div class="section-header">Restaurant Table Overview</div>
              
              <!-- Dynamic sections will be populated by JavaScript -->
              <div id="overview-sections-container">
                <!-- All sections will be dynamically generated here -->
              </div>
            </div>

            <!-- Add Table Section -->
            <div id="add-section" class="management-section">
              <div class="section-header">Add New Table</div>
              <div class="add-table-form">
                <form id="addTableForm">
                  <div class="form-row">
                    <div class="form-group">
                      <label for="tableNumber">Table Number</label>
                      <input type="text" id="tableNumber" name="tableNumber" placeholder="e.g., T9, H17, V41" required>
                    </div>
                    <div class="form-group">
                      <label for="tableSection">Section</label>
                      <select id="tableSection" name="tableSection" required>
                        <option value="">Select Section</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="seatCapacity">Pax Capacity</label>
                      <input type="number" id="seatCapacity" name="paxCapacity" min="1" max="20" value="8" required>
                    </div>
                    <div class="form-group">
                      <label for="tableStatus">Initial Status</label>
                      <select id="tableStatus" name="tableStatus" required>
                        <option value="available">Available</option>
                        <option value="reserved">Reserved</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label for="vipRoom">VIP Room (if VIP Cabin)</label>
                      <select id="vipRoom" name="vipRoom">
                        <option value="">Not VIP</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="tableDescription">Description (Optional)</label>
                      <input type="text" id="tableDescription" name="tableDescription" placeholder="e.g., Near window, Corner table">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">➕ Add Table</button>
                </form>
              </div>
            </div>

            <!-- Edit Tables Section -->
            <div id="edit-section" class="management-section">
              <div class="section-header">Edit Existing Tables</div>
              <div class="tables-grid-admin" id="edit-tables-grid">
                <!-- Tables will be populated by JavaScript -->
              </div>
            </div>

            <!-- Seat Capacity Section -->
            <div id="capacity-section" class="management-section">
              <div class="section-header">Pax Capacity Management</div>
              <div class="add-table-form">
                <h4>Update Pax Capacities</h4>
                <div class="tables-grid-admin" id="capacity-tables-grid">
                  <!-- Tables will be populated by JavaScript -->
                </div>
              </div>
            </div>

            <!-- Manage Sections -->
            <div id="sections-section" class="management-section">
              <div class="section-header">Manage Sections</div>
              
              <!-- Add Section Form -->
              <div class="add-table-form">
                <h4>Add New Section</h4>
                <form id="addSectionForm">
                  <div class="form-row">
                    <div class="form-group">
                      <label for="sectionName">Section Name</label>
                      <input type="text" id="sectionName" name="sectionName" placeholder="e.g., Terrace, Garden, Balcony" required>
                    </div>
                    <div class="form-group">
                      <label for="sectionImage">Section Image (Optional)</label>
                      <input type="file" id="sectionImage" name="sectionImage" accept="image/*">
                      <small style="color: #666; display: block; margin-top: 5px;">Upload an image for this section</small>
                      <div id="newSectionImagePreview" style="margin-top: 10px; text-align: center;"></div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label for="sectionCapacity">Capacity</label>
                      <input type="text" id="sectionCapacity" name="sectionCapacity" placeholder="e.g., 4 – 10 pax">
                    </div>
                    <div class="form-group">
                      <label for="sectionInclusions">Inclusions</label>
                      <textarea id="sectionInclusions" name="sectionInclusions" rows="2" placeholder="e.g., Standard setup with comfortable seating and full dining service."></textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Add Section</button>
                </form>
              </div>

              <!-- Existing Sections -->
              <div style="margin-top: 30px;">
                <h4>Existing Sections</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;" id="sections-grid">
                  <!-- Sections will be populated by JavaScript -->
                </div>
              </div>
            </div>

          </div>
            </div>
</div>
      </div>
    </div>
    <!-- JavaScript files-->
   @include('admin.js')

   <script>
   document.addEventListener('DOMContentLoaded', function() {
       // Default table data
      const defaultTables = {
          // Section A (A1–A4)
          'A1': { number: 'A1', section: 'hallway', seats: 8, status: 'available', description: '' },
          'A2': { number: 'A2', section: 'hallway', seats: 8, status: 'available', description: '' },
          'A3': { number: 'A3', section: 'hallway', seats: 8, status: 'reserved', description: '' },
          'A4': { number: 'A4', section: 'hallway', seats: 8, status: 'available', description: '' },

          // Section B (B1–B4)
          'B1': { number: 'B1', section: 'top', seats: 8, status: 'available', description: '' },
          'B2': { number: 'B2', section: 'top', seats: 8, status: 'reserved', description: '' },
          'B3': { number: 'B3', section: 'top', seats: 8, status: 'available', description: '' },
          'B4': { number: 'B4', section: 'top', seats: 8, status: 'available', description: '' },

          // Garden (G1–G4)
          'G1': { number: 'G1', section: 'garden', seats: 6, status: 'available', description: '' },
          'G2': { number: 'G2', section: 'garden', seats: 6, status: 'available', description: '' },
          'G3': { number: 'G3', section: 'garden', seats: 8, status: 'reserved', description: '' },
          'G4': { number: 'G4', section: 'garden', seats: 8, status: 'available', description: '' },

          // VIP Cabin Room Tables (example set)
          'V11': { number: 'V11', section: 'vip', seats: 8, status: 'available', room: 1, description: '' },
          'V12': { number: 'V12', section: 'vip', seats: 8, status: 'reserved', room: 1, description: '' },
          'V13': { number: 'V13', section: 'vip', seats: 8, status: 'available', room: 1, description: '' },
          'V21': { number: 'V21', section: 'vip', seats: 8, status: 'available', room: 2, description: '' },
          'V22': { number: 'V22', section: 'vip', seats: 8, status: 'available', room: 2, description: '' },
          'V23': { number: 'V23', section: 'vip', seats: 8, status: 'reserved', room: 2, description: '' },
          'V31': { number: 'V31', section: 'vip', seats: 8, status: 'reserved', room: 3, description: '' },
          'V32': { number: 'V32', section: 'vip', seats: 8, status: 'available', room: 3, description: '' },
          'V33': { number: 'V33', section: 'vip', seats: 8, status: 'available', room: 3, description: '' }
      };

       // Load tables from localStorage or use defaults
       let tables = JSON.parse(localStorage.getItem('restaurantTables')) || defaultTables;
       
       // Default sections data
          const sectionAInclusions = 'Standard setup (table, chairs, basic décor)';
          const defaultSections = {
              'hallway': { 
                  name: 'Section A', 
                  icon: '🪑', 
                  value: 'hallway',
                  image: '',
                  capacity: '4 – 10 pax',
                  inclusions: sectionAInclusions
              },
              'top': { 
                  name: 'Section B', 
                  icon: '', 
                  value: 'top',
                  image: '',
                  capacity: '',
                  inclusions: ''
              },
              'garden': { 
                  name: 'Garden', 
                  icon: '', 
                  value: 'garden',
                  image: '',
                  capacity: '',
                  inclusions: ''
              },
              'vip': { 
                  name: 'VIP Cabin Room', 
                  icon: '', 
                  value: 'vip',
                  image: '',
                  capacity: '',
                  inclusions: ''
              }
         };

      // Load sections from localStorage or use defaults
      let sections = JSON.parse(localStorage.getItem('restaurantSections')) || defaultSections;

      // Ensure required "home" sections exist (data-safe upgrade)
      const requiredSections = defaultSections;
      Object.keys(requiredSections).forEach(k => {
          if (!sections[k]) sections[k] = requiredSections[k];
      });
      // Section A (hallway): always use this inclusion text
      if (sections.hallway) sections.hallway.inclusions = sectionAInclusions;

       // Maintain an explicit order array of section keys
       let sectionOrder = JSON.parse(localStorage.getItem('sectionOrder') || 'null') || Object.keys(sections);

       // Save sections to localStorage
       function saveSectionsToStorage() {
           localStorage.setItem('restaurantSections', JSON.stringify(sections));
           // Ensure order contains only existing keys and append new ones
           const existingKeys = Object.keys(sections);
           sectionOrder = (Array.isArray(sectionOrder) ? sectionOrder.filter(k => existingKeys.includes(k)) : []);
           existingKeys.forEach(k => { if (!sectionOrder.includes(k)) sectionOrder.push(k); });
           localStorage.setItem('sectionOrder', JSON.stringify(sectionOrder));
           
           // Trigger custom events for immediate updates
           window.dispatchEvent(new CustomEvent('sectionDataChanged', {
               detail: { sectionData: sections, sectionOrder: sectionOrder }
           }));
       }
       
       // Load table statuses from server on page load
       async function loadTableStatusesFromServer() {
           try {
               const response = await fetch('/table-status', {
                   method: 'GET',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                   }
               });
               
               if (response.ok) {
                   const data = await response.json();
                   if (data.success && data.tableStatus) {
                       // Update local tables with server statuses
                       Object.keys(data.tableStatus).forEach(tableNumber => {
                           if (tables[tableNumber]) {
                               tables[tableNumber].status = data.tableStatus[tableNumber];
                           }
                       });
                       saveTablesToStorage();
                       refreshAllSections();
                   }
               }
           } catch (error) {
               console.error('Error loading table statuses from server:', error);
           }
       }
       
       // Load table statuses when page loads
       loadTableStatusesFromServer();
       
       // Save tables to localStorage
       function saveTablesToStorage() {
           localStorage.setItem('restaurantTables', JSON.stringify(tables));
           // Also save table status for customer page
           const tableStatus = {};
           Object.keys(tables).forEach(tableNumber => {
               tableStatus[tableNumber] = tables[tableNumber].status;
           });
           localStorage.setItem('tableStatus', JSON.stringify(tableStatus));
           
           // Trigger custom events for immediate updates
           window.dispatchEvent(new CustomEvent('tableStatusChanged', {
               detail: { tableStatus: tableStatus }
           }));
           
           window.dispatchEvent(new CustomEvent('tableDataChanged', {
               detail: { tableData: tables }
           }));
       }

       // Management tab switching
       const managementTabs = document.querySelectorAll('.management-tab');
       const managementSections = document.querySelectorAll('.management-section');
       
       managementTabs.forEach(tab => {
           tab.addEventListener('click', function() {
               const targetSection = this.getAttribute('data-section');
               
               // Remove active class from all tabs and sections
               managementTabs.forEach(t => t.classList.remove('active'));
               managementSections.forEach(section => section.classList.remove('active'));
               
               // Add active class to clicked tab and corresponding section
               this.classList.add('active');
               document.getElementById(targetSection + '-section').classList.add('active');
               
               // Refresh the section content
               refreshSectionContent(targetSection);
           });
       });

       // Initialize the page
       console.log('Initializing page...');
       console.log('Tables loaded:', tables);
       console.log('Sections loaded:', sections);
       
       updateStatistics();
       updateSectionDropdowns();
       refreshSectionContent('overview');
       saveSectionsToStorage(); // persist Section A inclusion fix (and merged defaults)
       
       console.log('Page initialization complete');

       // Add table form submission
      document.getElementById('addTableForm').addEventListener('submit', function(e) {
           e.preventDefault();
           
           const formData = new FormData(this);
           const vipRoomRaw = formData.get('vipRoom');
           const tableData = {
               number: formData.get('tableNumber'),
               section: formData.get('tableSection'),
              seats: parseInt(formData.get('paxCapacity')),
               status: formData.get('tableStatus'),
               description: formData.get('tableDescription'),
               room: vipRoomRaw ? parseInt(vipRoomRaw, 10) : null
           };
           
           // Add table to data
           tables[tableData.number] = tableData;
           
           // Save to localStorage
           saveTablesToStorage();
           
           // Update all sections
           refreshAllSections();
           
           // Reset form
           this.reset();
           
           // Show success message
           showAlert('Table added successfully!', 'success');
       });

       // Add section form submission
       document.getElementById('addSectionForm').addEventListener('submit', async function(e) {
           e.preventDefault();
           
           const sectionName = document.getElementById('sectionName').value.trim();
           const sectionCapacity = document.getElementById('sectionCapacity').value.trim();
           const sectionInclusions = document.getElementById('sectionInclusions').value.trim();
           const imageFile = document.getElementById('sectionImage').files[0];
           
           if (!sectionName) {
               alert('Section name is required!');
               return;
           }
           
           // Generate section value (lowercase, no spaces)
           const sectionValue = sectionName.toLowerCase().replace(/\s+/g, '_');
           
           // Check if section already exists
           if (sections[sectionValue]) {
               alert('Section already exists!');
               return;
           }
           
           try {
               let imageUrl = '';
               
               // Upload image if provided
               if (imageFile) {
                   const formData = new FormData();
                   formData.append('image', imageFile);
                   formData.append('section_key', sectionValue);
                   formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                   
                   const response = await fetch('/admin/section/upload-image', {
                       method: 'POST',
                       body: formData
                   });
                   
                   const data = await response.json();
                   if (data.success) {
                       imageUrl = data.image_url;
                   } else {
                       alert('Error uploading image: ' + data.message);
                       return;
                   }
               }
               
               // Add new section
               sections[sectionValue] = {
                   name: sectionName,
                   icon: '',
                   value: sectionValue,
                   image: imageUrl,
                   capacity: sectionCapacity,
                   inclusions: sectionInclusions
               };
               // Maintain display order: append new key
               if (!Array.isArray(sectionOrder)) sectionOrder = [];
               sectionOrder.push(sectionValue);
               
               // Save to localStorage
               saveSectionsToStorage();
               
               // Reset form
               this.reset();
               document.getElementById('newSectionImagePreview').innerHTML = '';
               
               // Show success message
               showAlert(`Section "${sectionName}" added successfully!`, 'success');
               
               // Refresh sections display
               if (document.getElementById('sections-section').classList.contains('active')) {
                   renderSections();
               } else {
                   updateSectionDropdowns();
               }
           } catch (error) {
               console.error('Error adding section:', error);
               alert('Error adding section: ' + error.message);
           }
       });
       
       // Image preview for new section form
       document.getElementById('sectionImage')?.addEventListener('change', function(e) {
           const file = e.target.files[0];
           const previewDiv = document.getElementById('newSectionImagePreview');
           if (file && previewDiv) {
               const reader = new FileReader();
               reader.onload = function(e) {
                   previewDiv.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 8px;">`;
               };
               reader.readAsDataURL(file);
           }
       });

       function updateStatistics() {
           const totalTables = Object.keys(tables).length;
           const availableTables = Object.values(tables).filter(t => t.status === 'available').length;
           const reservedTables = Object.values(tables).filter(t => t.status === 'reserved').length;
           
           document.getElementById('totalTables').textContent = totalTables;
           document.getElementById('availableTables').textContent = availableTables;
           document.getElementById('reservedTables').textContent = reservedTables;
       }

       function refreshSectionContent(section) {
           console.log('refreshSectionContent called with section:', section);
           switch(section) {
               case 'overview':
                   console.log('Rendering overview section...');
                   renderOverviewTables();
                   break;
               case 'edit':
                   console.log('Rendering edit section...');
                   renderEditTables();
                   break;
               case 'capacity':
                   console.log('Rendering capacity section...');
                   renderCapacityTables();
                   break;
               case 'sections':
                   console.log('Rendering sections section...');
                   renderSections();
                   break;
               default:
                   console.log('Unknown section:', section);
           }
       }

       function renderOverviewTables() {
           console.log('renderOverviewTables called');
           console.log('Tables data:', tables);
           console.log('Sections data:', sections);
           
           const container = document.getElementById('overview-sections-container');
           if (!container) {
               console.error('Overview sections container not found!');
               return;
           }
           
           // Clear the container
           container.innerHTML = '';
           
           // Get all unique sections from tables
           const allSections = [...new Set(Object.values(tables).map(t => t.section))];
           console.log('All sections found in tables:', allSections);
           
           // Render each section
           Object.keys(sections).forEach(sectionKey => {
               const section = sections[sectionKey];
               const sectionTables = Object.values(tables).filter(t => t.section === sectionKey);
               
               console.log(`Rendering section: ${sectionKey}`, section, 'with tables:', sectionTables);
               
               if (sectionTables.length === 0) {
                   console.log(`No tables found for section: ${sectionKey}`);
                   return; // Skip sections with no tables
               }
               
               // Create section container
               const sectionDiv = document.createElement('div');
               sectionDiv.className = 'overview-section';
               sectionDiv.style.marginBottom = '30px';
               
               // Create section header with image/icon
               const sectionHeader = document.createElement('div');
               sectionHeader.style.marginBottom = '20px';
               sectionHeader.style.display = 'flex';
               sectionHeader.style.alignItems = 'center';
               sectionHeader.style.gap = '15px';
               sectionHeader.style.padding = '15px';
               sectionHeader.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
               sectionHeader.style.borderRadius = '10px';
               sectionHeader.style.color = 'white';
               
               // Section image or icon
               const sectionImageDiv = document.createElement('div');
               if (section.image) {
                   sectionImageDiv.innerHTML = `<img src="${section.image}" alt="${section.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid white;">`;
               } else if (section.icon) {
                   sectionImageDiv.innerHTML = `<div style="font-size: 2.5em;">${section.icon}</div>`;
               } else {
                   sectionImageDiv.innerHTML = `<div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.5em;">📋</div>`;
               }
               
               // Section info
               const sectionInfoDiv = document.createElement('div');
               sectionInfoDiv.style.flex = '1';
               const sectionTitle = document.createElement('h3');
               sectionTitle.textContent = section.name;
               sectionTitle.style.margin = '0 0 5px 0';
               sectionTitle.style.color = 'white';
               sectionTitle.style.fontSize = '1.3em';
               sectionInfoDiv.appendChild(sectionTitle);
               
               if (section.capacity) {
                   const capacityDiv = document.createElement('div');
                   capacityDiv.textContent = `Capacity: ${section.capacity}`;
                   capacityDiv.style.fontSize = '0.9em';
                   capacityDiv.style.opacity = '0.9';
                   capacityDiv.style.marginBottom = '3px';
                   sectionInfoDiv.appendChild(capacityDiv);
               }
               
               if (section.inclusions) {
                   const inclusionsDiv = document.createElement('div');
                   inclusionsDiv.textContent = section.inclusions;
                   inclusionsDiv.style.fontSize = '0.85em';
                   inclusionsDiv.style.opacity = '0.85';
                   inclusionsDiv.style.fontStyle = 'italic';
                   sectionInfoDiv.appendChild(inclusionsDiv);
               }
               
               sectionHeader.appendChild(sectionImageDiv);
               sectionHeader.appendChild(sectionInfoDiv);
               sectionDiv.appendChild(sectionHeader);
               
               // Handle VIP section specially (with rooms)
               if (sectionKey === 'vip') {
                   const vipRooms = [1, 2, 3, 4, 5]; // Support up to 5 VIP rooms
                   let renderedAnyVipGroup = false;
                   
                   vipRooms.forEach(roomNum => {
                       const roomTables = sectionTables.filter(t => Number(t.room) === roomNum);
                       
                       if (roomTables.length > 0) {
                           renderedAnyVipGroup = true;
                           const roomDiv = document.createElement('div');
                           // Show a generic VIP Cabin heading without "Room 1" text
                           roomDiv.innerHTML = `<h4 style="margin: 15px 0 10px 0; color: #666;">VIP Cabin</h4>`;
                           roomDiv.className = 'mb-3';
                           
                           const roomTablesDiv = document.createElement('div');
                           roomTablesDiv.className = 'tables-grid-admin mb-4';
                           
                           console.log(`VIP Room ${roomNum} tables:`, roomTables);
                           
                           roomTables.forEach(table => {
                               const tableCard = createTableCard(table, 'overview');
                               roomTablesDiv.appendChild(tableCard);
                           });
                           
                           roomDiv.appendChild(roomTablesDiv);
                           sectionDiv.appendChild(roomDiv);
                       }
                   });

                   // If VIP tables exist but no room matched (e.g., missing/invalid room), show them anyway.
                   const unassignedVipTables = sectionTables.filter(t => {
                       const r = t.room;
                       if (r === null || r === undefined || r === '') return true;
                       return Number.isNaN(Number(r));
                   });
                   if (unassignedVipTables.length > 0) {
                       renderedAnyVipGroup = true;
                       const unassignedDiv = document.createElement('div');
                       unassignedDiv.className = 'mb-3';
                       
                       const unassignedTablesDiv = document.createElement('div');
                       unassignedTablesDiv.className = 'tables-grid-admin mb-4';
                       
                       unassignedVipTables.forEach(table => {
                           const tableCard = createTableCard(table, 'overview');
                           unassignedTablesDiv.appendChild(tableCard);
                       });
                       
                       unassignedDiv.appendChild(unassignedTablesDiv);
                       sectionDiv.appendChild(unassignedDiv);
                   }

                   // Absolute fallback: never render a blank VIP section when tables exist.
                   if (!renderedAnyVipGroup && sectionTables.length > 0) {
                       const tablesGrid = document.createElement('div');
                       tablesGrid.className = 'tables-grid-admin';
                       sectionTables.forEach(table => {
                           const tableCard = createTableCard(table, 'overview');
                           tablesGrid.appendChild(tableCard);
                       });
                       sectionDiv.appendChild(tablesGrid);
                   }
               } else {
                   // Regular section (not VIP)
                   const tablesGrid = document.createElement('div');
                   tablesGrid.className = 'tables-grid-admin';
                   
                   sectionTables.forEach(table => {
                       const tableCard = createTableCard(table, 'overview');
                       tablesGrid.appendChild(tableCard);
                   });
                   
                   sectionDiv.appendChild(tablesGrid);
               }
               
               container.appendChild(sectionDiv);
           });
           
           console.log('Overview rendering complete');
       }

       function renderEditTables() {
           const editGrid = document.getElementById('edit-tables-grid');
           editGrid.innerHTML = '';
           
           Object.values(tables).forEach(table => {
               editGrid.appendChild(createTableCard(table, 'edit'));
           });
       }

       function renderCapacityTables() {
           const capacityGrid = document.getElementById('capacity-tables-grid');
           capacityGrid.innerHTML = '';
           
           Object.values(tables).forEach(table => {
               capacityGrid.appendChild(createTableCard(table, 'capacity'));
           });
       }

       function renderSections() {
           const sectionsGrid = document.getElementById('sections-grid');
           sectionsGrid.innerHTML = '';
           
           // Render using explicit order if available
           const orderedKeys = (Array.isArray(sectionOrder) && sectionOrder.length)
               ? sectionOrder.filter(k => sections[k])
               : Object.keys(sections);
           const usedSectionNames = new Set();
           orderedKeys.forEach(sectionKey => {
               const section = sections[sectionKey];
               if (!section || usedSectionNames.has(String(section.name).toLowerCase())) {
                   return;
               }
               usedSectionNames.add(String(section.name).toLowerCase());
               const sectionCard = document.createElement('div');
               sectionCard.className = 'table-item-admin';
               sectionCard.style.cssText = `
                   background: white;
                   padding: 20px;
                   border-radius: 10px;
                   box-shadow: 0 2px 8px rgba(0,0,0,0.1);
               `;
               
               // Display section image or icon
               const sectionImage = section.image 
                   ? `<img src="${section.image}" alt="${section.name}" style="width: 100%; max-width: 200px; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">`
                   : (section.icon ? `<div style="font-size: 3em; margin-bottom: 10px;">${section.icon}</div>` : '');
               
               sectionCard.innerHTML = `
                   ${sectionImage}
                   <div style="font-size: 1.2em; font-weight: bold; margin-bottom: 5px;">${section.name}</div>
                   ${section.capacity ? `<div style="font-size: 0.9em; color: #666; margin-bottom: 5px;"><strong>Capacity:</strong> ${section.capacity}</div>` : ''}
                   <div style="font-size: 0.9em; color: #666; margin-bottom: 10px;"><strong>Inclusions:</strong> ${section.inclusions || '—'}</div>
                  <div style="display: flex; gap: 8px;">
                      <button class="btn btn-warning" onclick="editSection('${sectionKey}')" style="flex: 1;">Edit</button>
                      <button class="btn btn-danger" onclick="deleteSection('${sectionKey}')" style="flex: 1;">Delete</button>
                   </div>
               `;
               
               sectionsGrid.appendChild(sectionCard);
           });
           
           // Update all section dropdowns
           updateSectionDropdowns();
       }

       function updateSectionDropdowns() {
           // Update Add Table form dropdown
           const addTableSectionDropdown = document.getElementById('tableSection');
           if (addTableSectionDropdown) {
               // Save current selection
               const currentValue = addTableSectionDropdown.value;
               
               // Clear and rebuild
               addTableSectionDropdown.innerHTML = '<option value="">Select Section</option>';
               const orderedKeys = (Array.isArray(sectionOrder) && sectionOrder.length)
                   ? sectionOrder.filter(k => sections[k])
                   : Object.keys(sections);
               const usedSectionNames = new Set();
               orderedKeys.forEach(sectionKey => {
                   const section = sections[sectionKey];
                   if (!section) return;
                   const nameKey = String(section.name).toLowerCase();
                   if (usedSectionNames.has(nameKey)) return;
                   usedSectionNames.add(nameKey);
                   const option = document.createElement('option');
                   option.value = sectionKey;
                   option.textContent = `${section.name}`;
                   addTableSectionDropdown.appendChild(option);
               });
               
               // Restore selection if it still exists
               if (currentValue && sections[currentValue]) {
                   addTableSectionDropdown.value = currentValue;
               }
           }
           
           // Update edit table modal dropdown if it exists
           const editTableSectionDropdown = document.getElementById('editTableSection');
           if (editTableSectionDropdown) {
               const currentValue = editTableSectionDropdown.value;
               editTableSectionDropdown.innerHTML = '';
               const orderedKeys2 = (Array.isArray(sectionOrder) && sectionOrder.length)
                   ? sectionOrder.filter(k => sections[k])
                   : Object.keys(sections);
               const usedSectionNames2 = new Set();
               orderedKeys2.forEach(sectionKey => {
                   const section = sections[sectionKey];
                   if (!section) return;
                   const nameKey = String(section.name).toLowerCase();
                   if (usedSectionNames2.has(nameKey)) return;
                   usedSectionNames2.add(nameKey);
                   const option = document.createElement('option');
                   option.value = sectionKey;
                   option.textContent = `${section.name}`;
                   if (sectionKey === currentValue) {
                       option.selected = true;
                   }
                   editTableSectionDropdown.appendChild(option);
               });
           }
       }

       window.editSection = function(sectionKey) {
           const section = sections[sectionKey];
           if (!section) return;
           
           // Create edit modal
           const modal = document.createElement('div');
           modal.className = 'edit-section-modal';
           modal.style.cssText = `
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               background: rgba(0,0,0,0.5);
               z-index: 10000;
               display: flex;
               align-items: center;
               justify-content: center;
           `;
           
           // Get current image preview
           const currentImagePreview = section.image 
               ? `<img src="${section.image}" alt="Current image" style="max-width: 200px; max-height: 150px; border-radius: 8px; margin-bottom: 10px;">`
               : (section.icon ? `<div style="font-size: 2em; margin-bottom: 10px;">${section.icon}</div>` : '<div style="margin-bottom: 10px; color: #999;">No image uploaded</div>');
           
           modal.innerHTML = `
               <div class="edit-modal-content" style="
                   background: white;
                   padding: 30px;
                   border-radius: 15px;
                   box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                   max-width: 600px;
                   width: 90%;
                   max-height: 90vh;
                   overflow-y: auto;
               ">
                   <h3 style="margin-bottom: 20px; color: #333;">Edit Section: ${section.name}</h3>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Section Name:</label>
                       <input type="text" id="editSectionName" value="${section.name}" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       " placeholder="e.g., Section A">
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Current Image/Icon:</label>
                       <div id="currentImagePreview" style="text-align: center;">
                           ${currentImagePreview}
                       </div>
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Upload New Image:</label>
                       <input type="file" id="editSectionImage" accept="image/*" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       ">
                       <small style="color: #666; display: block; margin-top: 5px;">Upload an image to replace the emoji/icon</small>
                       <div id="imagePreview" style="margin-top: 10px; text-align: center;"></div>
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Capacity:</label>
                       <input type="text" id="editSectionCapacity" value="${section.capacity || ''}" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       " placeholder="e.g., 4 – 10 pax">
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Inclusions:</label>
                       <textarea id="editSectionInclusions" rows="3" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                           resize: vertical;
                       " placeholder="e.g., Standard setup with comfortable seating and full dining service.">${section.inclusions || ''}</textarea>
                   </div>
                   
                   <div style="display: flex; gap: 10px; justify-content: flex-end;">
                       <button onclick="closeEditSectionModal()" style="
                           padding: 10px 20px;
                           background: #6c757d;
                           color: white;
                           border: none;
                           border-radius: 8px;
                           cursor: pointer;
                           font-size: 16px;
                       ">Cancel</button>
                       <button onclick="saveSectionEdit('${sectionKey}')" style="
                           padding: 10px 20px;
                           background: #007bff;
                           color: white;
                           border: none;
                           border-radius: 8px;
                           cursor: pointer;
                           font-size: 16px;
                       ">Save Changes</button>
                   </div>
               </div>
           `;
           
           document.body.appendChild(modal);
           
           // Image preview handler
           const imageInput = document.getElementById('editSectionImage');
           const previewDiv = document.getElementById('imagePreview');
           
           imageInput.addEventListener('change', function(e) {
               const file = e.target.files[0];
               if (file) {
                   const reader = new FileReader();
                   reader.onload = function(e) {
                       previewDiv.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 8px;">`;
                   };
                   reader.readAsDataURL(file);
               }
           });
           
           // Close modal when clicking outside
           modal.addEventListener('click', function(e) {
               if (e.target === modal) {
                   window.closeEditSectionModal();
               }
           });
       };
       
       window.closeEditSectionModal = function() {
           const modal = document.querySelector('.edit-section-modal');
           if (modal) {
               modal.remove();
           }
       };
       
       window.saveSectionEdit = async function(sectionKey) {
           const section = sections[sectionKey];
           if (!section) return;
           
           const newName = document.getElementById('editSectionName').value.trim();
           const newCapacity = document.getElementById('editSectionCapacity').value.trim();
           const newInclusions = document.getElementById('editSectionInclusions').value.trim();
           const imageFile = document.getElementById('editSectionImage').files[0];
           
           if (!newName) {
               alert('Section name is required!');
               return;
           }
           
           try {
               let imageUrl = section.image || '';
               
               // Upload image if provided
               if (imageFile) {
                   const formData = new FormData();
                   formData.append('image', imageFile);
                   formData.append('section_key', sectionKey);
                   formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                   
                   const response = await fetch('/admin/section/upload-image', {
                       method: 'POST',
                       body: formData
                   });
                   
                   const data = await response.json();
                   if (data.success) {
                       imageUrl = data.image_url;
                   } else {
                       alert('Error uploading image: ' + data.message);
                       return;
                   }
               }
               
               // Update section data
               section.name = newName;
               section.capacity = newCapacity;
               section.inclusions = newInclusions;
               if (imageUrl) {
                   section.image = imageUrl;
                   section.icon = ''; // Clear icon when image is set
               }
               
               // Save to localStorage
               saveSectionsToStorage();
               
               // Refresh display
               renderSections();
               updateSectionDropdowns();
               refreshAllSections();
               
               // Close modal
               window.closeEditSectionModal();
               
               // Show success message
               showAlert(`Section "${newName}" updated successfully!`, 'success');
           } catch (error) {
               console.error('Error saving section:', error);
               alert('Error saving section: ' + error.message);
           }
       };

       window.deleteSection = function(sectionKey) {
           const section = sections[sectionKey];
           if (!section) return;
           
           // Check if there are tables using this section
           const tablesInSection = Object.values(tables).filter(t => t.section === sectionKey).length;
           
           if (tablesInSection > 0) {
               alert(`Cannot delete this section! There are ${tablesInSection} table(s) using this section. Please move or delete those tables first.`);
               return;
           }
           
           if (!confirm(`Are you sure you want to delete section "${section.name}"?`)) {
               return;
           }
           
           delete sections[sectionKey];
           saveSectionsToStorage();
           renderSections();
           updateSectionDropdowns();
           showAlert(`Section "${section.name}" deleted successfully!`, 'success');
       };

      function createTableCard(table, mode) {
           const card = document.createElement('div');
           card.className = `table-item-admin ${table.status}`;
          const seats = (table && typeof table.seats === 'number') ? table.seats : (typeof table.pax === 'number' ? table.pax : 8);
           
           let actionsHtml = '';
           if (mode === 'edit') {
               actionsHtml = `
                   <div class="table-actions">
                       <button class="btn btn-warning" onclick="editTable('${table.number}')">Edit</button>
                       <button class="btn btn-danger" onclick="deleteTable('${table.number}')">Delete</button>
                   </div>
               `;
           } else if (mode === 'capacity') {
               actionsHtml = `
                   <div class="table-actions">
                      <input type="number" value="${seats}" min="1" max="20" 
                              onchange="updateSeatCapacity('${table.number}', this.value)" 
                              oninput="updateSeatCapacityRealtime('${table.number}', this.value); this.style.backgroundColor='#e3f2fd'"
                              onblur="this.style.backgroundColor='white'"
                              style="width: 60px; text-align: center; margin: 5px; border: 2px solid #007bff; border-radius: 4px;">
                   </div>
               `;
           }
           
           card.innerHTML = `
               <div class="table-number-admin">${table.number}</div>
              <div class="table-seats-admin">${seats} pax</div>
               <div class="table-status-admin ${table.status}">${table.status.charAt(0).toUpperCase() + table.status.slice(1)}</div>
               ${table.description ? `<div style="font-size: 0.8em; color: #666;">${table.description}</div>` : ''}
               ${actionsHtml}
           `;
           
           return card;
       }

       // Helper function to refresh all sections
       function refreshAllSections() {
           updateStatistics();
           refreshSectionContent('overview');
           refreshSectionContent('edit');
           refreshSectionContent('capacity');
       }
       
       // Real-time table status management
       let currentTableStatus = {};
       
       // Load table status from server
      async function loadTableStatus() {
           try {
              const response = await fetch('/table-status');
               const data = await response.json();
               
               if (data.success) {
                   currentTableStatus = data.tableStatus;
                   renderStatusControl();
               } else {
                   console.error('Error loading table status:', data.message);
               }
           } catch (error) {
               console.error('Error fetching table status:', error);
           }
       }
       
       // Render status control section
       function renderStatusControl() {
           const topSection = document.getElementById('top-section-status');
           const hallwaySection = document.getElementById('hallway-section-status');
           const vipSection = document.getElementById('vip-section-status');
           
           if (topSection) {
               topSection.innerHTML = '';
               Object.values(tables).filter(table => table.number.startsWith('T')).forEach(table => {
                   const status = currentTableStatus[table.number] || 'available';
                   topSection.appendChild(createStatusControlCard(table, status));
               });
           }
           
           if (hallwaySection) {
               hallwaySection.innerHTML = '';
               Object.values(tables).filter(table => table.number.startsWith('H')).forEach(table => {
                   const status = currentTableStatus[table.number] || 'available';
                   hallwaySection.appendChild(createStatusControlCard(table, status));
               });
           }
           
           if (vipSection) {
               vipSection.innerHTML = '';
               Object.values(tables).filter(table => table.number.startsWith('V')).forEach(table => {
                   const status = currentTableStatus[table.number] || 'available';
                   vipSection.appendChild(createStatusControlCard(table, status));
               });
           }
       }
       
       // Create status control card
       function createStatusControlCard(table, status) {
           const card = document.createElement('div');
           card.className = `table-item-admin status-control ${status}`;
           card.onclick = () => toggleTableStatus(table.number);
           
           card.innerHTML = `
               <div class="table-number-admin">${table.number}</div>
               <div class="table-seats-admin">${table.seats} pax</div>
               <div class="table-status-admin ${status}">
               ${status === 'available' ? 'Available' : 'Reserved'}
               </div>
               <div class="status-indicator">
                   <span class="status-dot ${status}"></span>
               </div>
           `;
           
           return card;
       }
       
       // Toggle table status
      async function toggleTableStatus(tableNumber) {
           const currentStatus = currentTableStatus[tableNumber] || 'available';
           const newStatus = currentStatus === 'available' ? 'reserved' : 'available';
           
           try {
              const response = await fetch('/table-status', {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                   },
                   body: JSON.stringify({
                       table_number: tableNumber,
                       status: newStatus
                   })
               });
               
               const data = await response.json();
               
               if (data.success) {
                   currentTableStatus[tableNumber] = newStatus;
                   renderStatusControl();
                   updateStatistics();
                   
                   // Show success message
                   showStatusUpdateMessage(tableNumber, newStatus);
                   
                   // Broadcast update to public view
                   broadcastTableUpdate(tableNumber, newStatus);
               } else {
                   console.error('Error updating table status:', data.message);
                   alert('Error updating table status: ' + data.message);
               }
           } catch (error) {
               console.error('Error updating table status:', error);
               alert('Error updating table status. Please try again.');
           }
       }
       
       // Set all tables to a specific status
      async function setAllTablesStatus(status) {
           if (!confirm(`Are you sure you want to set ALL tables to ${status}?`)) {
               return;
           }
           
           const allTables = Object.keys(currentTableStatus);
           let successCount = 0;
           
           for (const tableNumber of allTables) {
               try {
                  const response = await fetch('/table-status', {
                       method: 'POST',
                       headers: {
                           'Content-Type': 'application/json',
                           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                       },
                       body: JSON.stringify({
                           table_number: tableNumber,
                           status: status
                       })
                   });
                   
                   const data = await response.json();
                   if (data.success) {
                       currentTableStatus[tableNumber] = status;
                       successCount++;
                   }
               } catch (error) {
                   console.error(`Error updating table ${tableNumber}:`, error);
               }
           }
           
           renderStatusControl();
           updateStatistics();
           showBulkUpdateMessage(successCount, status);
       }
       
       // Refresh table status
       function refreshTableStatus() {
           loadTableStatus();
       }
       
       // Show status update message
       function showStatusUpdateMessage(tableNumber, status) {
           const message = document.createElement('div');
           message.className = 'status-update-message';
           message.style.cssText = `
               position: fixed;
               top: 20px;
               right: 20px;
               background: ${status === 'available' ? '#28a745' : '#dc3545'};
               color: white;
               padding: 15px 20px;
               border-radius: 8px;
               z-index: 9999;
               font-weight: bold;
               box-shadow: 0 4px 12px rgba(0,0,0,0.3);
           `;
           message.innerHTML = `
               ${status === 'available' ? '✅' : '❌'} Table ${tableNumber} is now ${status}
           `;
           
           document.body.appendChild(message);
           
           setTimeout(() => {
               if (message.parentElement) {
                   message.remove();
               }
           }, 3000);
       }
       
       // Show bulk update message
       function showBulkUpdateMessage(count, status) {
           const message = document.createElement('div');
           message.className = 'bulk-update-message';
           message.style.cssText = `
               position: fixed;
               top: 20px;
               right: 20px;
               background: #007bff;
               color: white;
               padding: 15px 20px;
               border-radius: 8px;
               z-index: 9999;
               font-weight: bold;
               box-shadow: 0 4px 12px rgba(0,0,0,0.3);
           `;
           message.innerHTML = `
               🔄 Updated ${count} tables to ${status}
           `;
           
           document.body.appendChild(message);
           
           setTimeout(() => {
               if (message.parentElement) {
                   message.remove();
               }
           }, 3000);
       }
       
       // Broadcast table update to public view
       function broadcastTableUpdate(tableNumber, status) {
           console.log(`Broadcasting table update: ${tableNumber} -> ${status}`);
           
           const updateData = {
               table_number: tableNumber,
               status: status,
               timestamp: new Date().toISOString()
           };
           
           // Method 1: Store in localStorage for cross-tab communication
           localStorage.setItem('tableStatusUpdate', JSON.stringify(updateData));
           
           // Method 2: Dispatch custom event
           window.dispatchEvent(new CustomEvent('tableStatusUpdated', {
               detail: updateData
           }));
           
           // Method 3: Post message to all windows (if in same origin)
           try {
               window.postMessage({
                   type: 'tableStatusUpdate',
                   table_number: tableNumber,
                   status: status,
                   timestamp: updateData.timestamp
               }, '*');
           } catch (error) {
               console.log('PostMessage not available:', error);
           }
           
           // Method 4: Trigger storage event manually
           try {
               const event = new StorageEvent('storage', {
                   key: 'tableStatusUpdate',
                   newValue: JSON.stringify(updateData),
                   oldValue: null,
                   storageArea: localStorage
               });
               window.dispatchEvent(event);
           } catch (error) {
               console.log('Storage event not available:', error);
           }
           
           console.log('Broadcast completed for table:', tableNumber);
       }
       
       // Test real-time update function
       function testRealTimeUpdate() {
           const testTable = 'T1'; // Test with table T1
           const testStatus = currentTableStatus[testTable] === 'available' ? 'reserved' : 'available';
           
           console.log(`Testing real-time update: ${testTable} -> ${testStatus}`);
           
           // Update the status
           currentTableStatus[testTable] = testStatus;
           
           // Broadcast the update
           broadcastTableUpdate(testTable, testStatus);
           
           // Show test message
           showStatusUpdateMessage(testTable, testStatus);
           
           // Refresh the display
           renderStatusControl();
       }

       // Global functions for table management
       window.editTable = function(tableNumber) {
           const table = tables[tableNumber];
           if (!table) return;
           
           // Create edit modal
           const modal = document.createElement('div');
           modal.className = 'edit-table-modal';
           modal.style.cssText = `
               position: fixed;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               background: rgba(0,0,0,0.5);
               z-index: 10000;
               display: flex;
               align-items: center;
               justify-content: center;
           `;
           
           modal.innerHTML = `
               <div class="edit-modal-content" style="
                   background: white;
                   padding: 30px;
                   border-radius: 15px;
                   box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                   max-width: 500px;
                   width: 90%;
               ">
                   <h3 style="margin-bottom: 20px; color: #333;">Edit Table</h3>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Table Number:</label>
                       <input type="text" id="editTableNumber" value="${tableNumber}" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       " placeholder="e.g., T9, H17, V41">
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Section:</label>
                       <select id="editTableSection" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       ">
                       </select>
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Status:</label>
                       <select id="editTableStatus" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       ">
                           <option value="available" ${table.status === 'available' ? 'selected' : ''}>Available</option>
                           <option value="reserved" ${table.status === 'reserved' ? 'selected' : ''}>Reserved</option>
                       </select>
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Pax Capacity:</label>
                       <input type="number" id="editTableSeats" value="${table.seats}" min="1" max="20" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       ">
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">VIP Room (if VIP section):</label>
                       <select id="editTableRoom" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       ">
                           <option value="">Not Applicable</option>
                           <option value="1" ${table.room === 1 ? 'selected' : ''}>1</option>
                           <option value="2" ${table.room === 2 ? 'selected' : ''}>2</option>
                           <option value="3" ${table.room === 3 ? 'selected' : ''}>3</option>
                           <option value="4" ${table.room === 4 ? 'selected' : ''}>4</option>
                           <option value="5" ${table.room === 5 ? 'selected' : ''}>5</option>
                       </select>
                   </div>
                   
                   <div class="form-group" style="margin-bottom: 20px;">
                       <label style="display: block; margin-bottom: 8px; font-weight: bold;">Description (Optional):</label>
                       <input type="text" id="editTableDescription" value="${table.description || ''}" style="
                           width: 100%;
                           padding: 10px;
                           border: 2px solid #ddd;
                           border-radius: 8px;
                           font-size: 16px;
                       " placeholder="e.g., Near window, Corner table">
                   </div>
                   
                   <div style="display: flex; gap: 10px; justify-content: flex-end;">
                       <button onclick="closeEditModal()" style="
                           padding: 10px 20px;
                           background: #6c757d;
                           color: white;
                           border: none;
                           border-radius: 8px;
                           cursor: pointer;
                           font-size: 16px;
                       ">Cancel</button>
                       <button onclick="saveTableEdit('${tableNumber}')" style="
                           padding: 10px 20px;
                           background: #007bff;
                           color: white;
                           border: none;
                           border-radius: 8px;
                           cursor: pointer;
                           font-size: 16px;
                       ">Save Changes</button>
                   </div>
               </div>
           `;
           
           document.body.appendChild(modal);
           
           // Populate section dropdown
           const editSectionDropdown = document.getElementById('editTableSection');
           if (editSectionDropdown) {
               Object.keys(sections).forEach(sectionKey => {
                   const section = sections[sectionKey];
                   const option = document.createElement('option');
                   option.value = sectionKey;
                   option.textContent = `${section.name}`;
                   if (sectionKey === table.section) {
                       option.selected = true;
                   }
                   editSectionDropdown.appendChild(option);
               });
           }
           
           // Close modal when clicking outside
           modal.addEventListener('click', function(e) {
               if (e.target === modal) {
                   window.closeEditModal();
               }
           });
       }
       
       // Close edit modal
       window.closeEditModal = function() {
           const modal = document.querySelector('.edit-table-modal');
           if (modal) {
               modal.remove();
           }
       }
       
       // Save table edit
       window.saveTableEdit = async function(tableNumber) {
           const newTableNumber = document.getElementById('editTableNumber').value.trim();
           const newSection = document.getElementById('editTableSection').value;
           const newStatus = document.getElementById('editTableStatus').value;
           const newSeats = parseInt(document.getElementById('editTableSeats').value);
           const newRoom = document.getElementById('editTableRoom').value;
           const newDescription = document.getElementById('editTableDescription').value;
           
           console.log('Saving table edit:', { tableNumber, newTableNumber, newSection, newStatus, newSeats, newRoom, newDescription });
           
           try {
               // Validate new table number
               if (!newTableNumber) {
                   alert('Table number is required!');
                   return;
               }
               
               // If table number changed, handle the rename
               if (newTableNumber !== tableNumber) {
                   // Check if new table number already exists
                   if (tables[newTableNumber]) {
                       alert(`Table number ${newTableNumber} already exists!`);
                       return;
                   }
                   
                   // Get the old table data
                   const oldTableData = tables[tableNumber];
                   
                   // Update the table data with new number
                   if (oldTableData) {
                       // Create new table with updated information
                       tables[newTableNumber] = {
                           number: newTableNumber,
                           section: newSection,
                           status: newStatus,
                           seats: newSeats,
                           room: newRoom ? parseInt(newRoom) : null,
                           description: newDescription
                       };
                       
                       // Delete old table entry
                       delete tables[tableNumber];
                       
                       // Update status mapping if exists
                       if (currentTableStatus[tableNumber]) {
                           currentTableStatus[newTableNumber] = newStatus;
                           delete currentTableStatus[tableNumber];
                       }
                   }
               } else {
                   // Table number didn't change, just update the data
                   if (tables[tableNumber]) {
                       const oldSection = tables[tableNumber].section;
                       
                       tables[tableNumber].section = newSection;
                       tables[tableNumber].status = newStatus;
                       tables[tableNumber].seats = newSeats;
                       tables[tableNumber].room = newRoom ? parseInt(newRoom) : null;
                       tables[tableNumber].description = newDescription;
                       tables[tableNumber].number = newTableNumber; // Update number property
                       
                       // If section changed, save tables immediately to update display
                       if (oldSection !== newSection) {
                           saveTablesToStorage();
                       }
                   }
               }
               
               // Update table status on server
               const baseUrl = window.location.protocol + '//' + window.location.host;
               const url = baseUrl + '/table-status';
               console.log('Making request to:', url);
               console.log('Current location:', window.location.href);
               console.log('Base URL:', baseUrl);
               const response = await fetch(url, {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                   },
                   body: JSON.stringify({
                       table_number: newTableNumber,
                       old_table_number: newTableNumber !== tableNumber ? tableNumber : undefined,
                       status: newStatus,
                       seat_capacity: newSeats,
                       section: newSection,
                       room: newRoom,
                       description: newDescription
                   })
               });
               
               console.log('Response status:', response.status);
               
               if (!response.ok) {
                   throw new Error(`HTTP error! status: ${response.status}`);
               }
               
               const data = await response.json();
               console.log('Response data:', data);
               
               if (data.success) {
                   // Update current table status with new table number
                   currentTableStatus[newTableNumber] = newStatus;
                   
                   // Save to localStorage
                   saveTablesToStorage();
                   
                   // Refresh all sections
                   refreshAllSections();
                   
                   // Show success message
                   showStatusUpdateMessage(newTableNumber, newStatus);
                   
                   // Broadcast update to public view
                   broadcastTableUpdate(newTableNumber, newStatus);
                   
                   // Close modal
                   window.closeEditModal();
                   
                   // Show additional success message
                   const messageText = newTableNumber !== tableNumber 
                       ? `Table renamed from ${tableNumber} to ${newTableNumber} successfully!` 
                       : `Table ${newTableNumber} updated successfully!`;
                   showAlert(messageText, 'success');
               } else {
                   alert('Error updating table: ' + data.message);
               }
           } catch (error) {
               console.error('Error saving table edit:', error);
               alert('Error saving changes: ' + error.message);
           }
       }

       // Test function to manually trigger overview rendering
       window.testOverview = function() {
           console.log('Manual test of overview rendering...');
           console.log('Current tables:', tables);
           console.log('Current sections:', sections);
           
           // Force refresh overview section
           refreshSectionContent('overview');
           
           // Check if container exists
           const container = document.getElementById('overview-sections-container');
           
           console.log('DOM elements found:');
           console.log('- Overview container:', container);
           console.log('- Container children:', container ? container.children.length : 'N/A');
           
           // Check for garden section specifically
           const gardenTables = Object.values(tables).filter(t => t.section === 'garden');
           console.log('Garden tables found:', gardenTables);
           
           return {
               tables: tables,
               sections: sections,
               container: container,
               gardenTables: gardenTables
           };
       };

       // Helper function to add a test garden table
       window.addTestGardenTable = function() {
           const gardenTable = {
               number: 'G1',
               section: 'garden',
               seats: 6,
               status: 'available',
               description: 'Garden table near the flowers'
           };
           
           tables[gardenTable.number] = gardenTable;
           saveTablesToStorage();
           refreshAllSections();
           
           console.log('Added test garden table:', gardenTable);
           showAlert('Test garden table G1 added!', 'success');
           
           return gardenTable;
       };

       // Test function to check if routes are accessible
       window.testRoute = async function() {
           try {
               const baseUrl = window.location.protocol + '//' + window.location.host;
               const testUrl = baseUrl + '/test-table-route';
               console.log('Testing route:', testUrl);
               
               const response = await fetch(testUrl, {
                   method: 'GET',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                   }
               });
               
               console.log('Test route response status:', response.status);
               const data = await response.json();
               console.log('Test route response data:', data);
               return data;
           } catch (error) {
               console.error('Test route error:', error);
               return null;
           }
       };

       window.deleteTable = function(tableNumber) {
           if (confirm(`Are you sure you want to delete table ${tableNumber}?`)) {
               delete tables[tableNumber];
               
               // Save to localStorage
               saveTablesToStorage();
               
               // Update all sections
               refreshAllSections();
               showAlert(`Table ${tableNumber} deleted successfully`, 'success');
           }
       };

       // Real-time capacity update function
       window.updateSeatCapacityRealtime = function(tableNumber, newCapacity) {
           if (tables[tableNumber] && newCapacity >= 1 && newCapacity <= 20) {
               tables[tableNumber].seats = parseInt(newCapacity);
               
               // Update the display immediately in current section
               const currentSection = document.querySelector('.management-section.active');
               if (currentSection) {
                   refreshSectionContent('capacity');
               }
           }
       };

       // Final capacity update function (called on blur/change)
       window.updateSeatCapacity = function(tableNumber, newCapacity) {
           if (tables[tableNumber]) {
               const oldCapacity = tables[tableNumber].seats;
               tables[tableNumber].seats = parseInt(newCapacity);
               
               // Save to localStorage
               saveTablesToStorage();
               
               // Update all sections immediately
               refreshAllSections();
               
               // Show success message with more detail
               showAlert(`Table ${tableNumber} pax updated from ${oldCapacity} to ${newCapacity}`, 'success');
               
               console.log(`Table ${tableNumber} seat capacity updated: ${oldCapacity} → ${newCapacity}`);
           }
       };

       function showAlert(message, type) {
           const alertDiv = document.createElement('div');
           alertDiv.className = `alert alert-${type}`;
           alertDiv.style.cssText = `
               position: fixed;
               top: 20px;
               right: 20px;
               padding: 15px 20px;
               border-radius: 8px;
               color: white;
               font-weight: bold;
               z-index: 10000;
               animation: slideInRight 0.3s ease-out;
           `;
           
           if (type === 'success') {
               alertDiv.style.backgroundColor = '#28a745';
           } else if (type === 'error') {
               alertDiv.style.backgroundColor = '#dc3545';
           }
           
           alertDiv.textContent = message;
           document.body.appendChild(alertDiv);
           
           setTimeout(() => {
               if (alertDiv.parentElement) {
                   alertDiv.remove();
               }
           }, 3000);
       }
   });
   </script>
  </body>
</html>
