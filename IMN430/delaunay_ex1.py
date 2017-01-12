#!/usr/bin/env python

import vtk
from vtk.util.colors import *

def main():
 
    # Generate some random points
    math = vtk.vtkMath()
    points = vtk.vtkPoints()
    for i in range(0, 8):
        points.InsertPoint(i, math.Random(0, 1), math.Random(0, 1), 0.0)
    
    # Create a polydata with the points we just created.
    profile = vtk.vtkPolyData()
    profile.SetPoints(points)
   
    # Perform a 2D Delaunay triangulation on them.
    delny = vtk.vtkDelaunay2D()
    delny.SetInputData(profile)
    mapMesh = vtk.vtkPolyDataMapper()
    mapMesh.SetInputConnection(delny.GetOutputPort())
    
    meshActor = vtk.vtkActor()
    meshActor.SetMapper(mapMesh)
    meshActor.GetProperty().SetColor(.1, .2, .4)
    meshActor.GetProperty().SetInterpolationToFlat()
    meshActor.GetProperty().SetRepresentationToWireframe()


    # We will now create a nice looking mesh by wrapping the edges in tubes,
    # and putting fat spheres at the points.
    extract = vtk.vtkExtractEdges()
    extract.SetInputConnection(delny.GetOutputPort())
    tubes = vtk.vtkTubeFilter()
    tubes.SetInputConnection(extract.GetOutputPort())
    tubes.SetRadius(0.01)
    tubes.SetNumberOfSides(6)
    
    mapEdges = vtk.vtkPolyDataMapper()
    mapEdges.SetInputConnection(tubes.GetOutputPort())
    
    edgeActor = vtk.vtkActor()
    edgeActor.SetMapper(mapEdges)
    edgeActor.GetProperty().SetColor(peacock)
    edgeActor.GetProperty().SetSpecularColor(1, 1, 1)
    edgeActor.GetProperty().SetSpecular(0.3)
    edgeActor.GetProperty().SetSpecularPower(20)
    edgeActor.GetProperty().SetAmbient(0.2)
    edgeActor.GetProperty().SetDiffuse(0.8)
    
    ball = vtk.vtkSphereSource()
    ball.SetRadius(0.025)
    ball.SetThetaResolution(12)
    ball.SetPhiResolution(12)
    balls = vtk.vtkGlyph3D()
    balls.SetInputConnection(delny.GetOutputPort())
    balls.SetSourceConnection(ball.GetOutputPort())
    mapBalls = vtk.vtkPolyDataMapper()
    mapBalls.SetInputConnection(balls.GetOutputPort())
    ballActor = vtk.vtkActor()
    ballActor.SetMapper(mapBalls)
    ballActor.GetProperty().SetColor(hot_pink)
    ballActor.GetProperty().SetSpecularColor(1, 1, 1)
    ballActor.GetProperty().SetSpecular(0.3)
    ballActor.GetProperty().SetSpecularPower(20)
    ballActor.GetProperty().SetAmbient(0.2)
    ballActor.GetProperty().SetDiffuse(0.8)
  
    # Create the rendering window, renderer, and interactive renderer
    ren = vtk.vtkRenderer()
    renWin = vtk.vtkRenderWindow()
    renWin.AddRenderer(ren)
    iren = vtk.vtkRenderWindowInteractor()
    iren.SetRenderWindow(renWin)
    
    ren_b = vtk.vtkRenderer()
    renWin_b = vtk.vtkRenderWindow()
    renWin_b.AddRenderer(ren_b)
    iren_b = vtk.vtkRenderWindowInteractor()
    iren_b.SetRenderWindow(renWin_b)
   
    # Add the actors to the renderer, set the background and size
    ren.AddActor(ballActor)
    ren.AddActor(edgeActor)
    ren.SetBackground(1, 1, 1)
    renWin.SetSize(500, 500)
     
    ren.ResetCamera()
    
    ren_b.AddActor(ballActor)
    #ren_b.AddActor(edgeActor)
    ren_b.SetBackground(1, 1, 1)
    renWin_b.SetSize(500, 500)
     
    ren_b.ResetCamera()
    
    # Interact with the data.
    iren_b.Initialize()
    renWin_b.Render()
    iren_b.Start()
    
    iren.Initialize()
    renWin.Render()
    iren.Start()    
 
main()