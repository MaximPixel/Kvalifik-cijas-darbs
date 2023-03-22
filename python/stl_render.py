import sys, getopt
from stl import mesh
from mpl_toolkits import mplot3d
from matplotlib import pyplot

opts, args = getopt.getopt(sys.argv[1:], "hfo:", ["help", "filepath=", "output="])

filepath = None
output = None

def print_usage():
    print("Usage: stl_render.py [-h] [-f FILEPATH] [-o OUTPUT FILEPATH]")

for opt, arg in opts:
    if opt in ("-h", "--help"):
        print_usage()
        exit()
    elif opt in ("-f", "--filepath"):
        filepath = arg
    elif opt in ("-o", "--output"):
        output = arg

if not filepath or not output:
    print_usage()
    exit()

figure = pyplot.figure(figsize=(16, 16))
axes = figure.add_subplot(projection="3d")

mesh = mesh.Mesh.from_file(filepath)
print(mesh);

axes.add_collection3d(mplot3d.art3d.Poly3DCollection(mesh.vectors))
axes.add_collection3d(mplot3d.art3d.Poly3DCollection(mesh.vectors, edgecolor="k"))

scale = mesh.points.flatten()
axes.auto_scale_xyz(scale, scale, scale)

pyplot.axis("off")
#pyplot.show()
print(output)
pyplot.savefig(output)